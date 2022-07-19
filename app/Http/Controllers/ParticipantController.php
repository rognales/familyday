<?php

namespace App\Http\Controllers;

use App\Member;
use App\Notifications\RegistrationIsConfirmed;
use App\Participant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('attend', 'delete');
    }

    public function index()
    {
        return view('layouts.theme');
    }

    public function store(Request $request)
    {
        // if (!(config('familyday.registration') || Auth::check())) {
        //   return Redirect::to(URL::previous() . "#registration")->withErrors('Please contact admin for details.')->withInput();
        // }

        // If registration is open or admin is logged in
        if (config('familyday.registration') || Auth::check()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:5',
                'staff_id' => 'required|unique:participants,staff_id,NULL,id,deleted_at,NULL',
                'email' => 'required|email',
                'dependant_relationship.*' => 'nullable|required_with:dependant_name.*',
                'dependant_age.*' => 'nullable|required_with:dependant_name.*|numeric',
            ], [
                'staff_id.unique' => 'Staff Id is already registered.',
                'staff_id.exists' => 'You\'re not member of TM HQ',
                'dependant_age.*.numeric' => 'Please enter number only for age',
                'dependant_age.*.required_with' => 'Dependants\' age is required',
                'dependant_relationship.*.required_with' => 'Please specify relationship',
            ]);

            // if user logged in, rule for TM HQ members only will be bypassed
            $validator->sometimes('staff_id', 'exists:App\Staff,staff_id', function () {
                return Auth::check() ? false : true;
            });
        }

        if ($validator->fails()) {
            return Redirect::to(URL::previous().'#registration')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        $participant = Participant::create([
            'name' => title_case(request('name')),
            'staff_id' => strtoupper(request('staff_id')),
            'email' => strtolower(request('email')),
            'member' => Member::where('staff_id', strtoupper(request('staff_id')))->count(),
            'is_vege' => request('vege') == 'true' ? true : false,
        ]);

        $dependants = [];
        foreach (request('dependant_name') as $key => $value) {
            if (isset($value)) { //check for existance of dependants
                array_push($dependants, [
                    'name' => title_case($value),
                    'relationship' => title_case(request('dependant_relationship')[$key]),
                    'age' => request('dependant_age')[$key],
                    'staff_id' => $participant->staff_id,
                    'participant_id' => $participant->id,
                ]);
            }
        }
        $participant->dependants()->createMany($dependants);

        //only send email if successfully created
        if (! $participant) {
            DB::rollBack();

            return Redirect::to(URL::previous().'#registration')->withErrors('Registration failed. Please contact admin for details.')->withInput();
        }

        DB::commit();

        $participant->notify(new RegistrationIsConfirmed($participant));

        return redirect()->route('registration_show', ['slug' => $participant->slug()]);
    }

    public function delete(Request $request)
    {
        $p = Participant::find($request->pid);
        $p->deleted_by = Auth::user()->id;
        $p->save();

        $p->delete();
        $p->dependants()->delete();
    }

    public function attend($slug)
    {
        $eventDay = Carbon::parse(config('familyday.eventday'));
        if (now()->lessThan($eventDay)) {
            return view('registration.error')->with('warning', "Hold up! You're here too soon. Come back on the event day.");
        }

        // Event day onwards
        $participant = Participant::findBySlug($slug);

        // QR code not valid or payment status = Pending
        if (! $participant) {
            return view('registration.error')->with('warning', 'QR code not valid or no payment info has been captured.');
        }

        if (! $participant->isPaid()) {
            return view('registration.error')->with('warning', 'No payment info has been captured.');
        }

        if ($participant->isAttended()) {
            return view('registration.error')->with('warning', 'QR code already scanned. Please contact commitee for assistance.');
        }

        $participant->markAttendance();

        return view('registration.show', compact('participant'));
    }

    public function show($slug)
    {
        $participant = Participant::findBySlug($slug);
        if (! $participant) {
            return view('registration.error')->with('warning', 'Registration not found.');
        }

        return view('registration.show', compact('participant'));
    }
}
