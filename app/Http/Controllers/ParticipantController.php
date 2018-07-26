<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Participant;
use App\Dependant;
use App\Member;
use App\Mail\RegistrationConfirmation;

class ParticipantController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->only('attend','sendEmail','delete');
    }

    public function index(){
        return view('layouts.theme');
    }

    public function store(Request $request){
      // registration closed
      if (Auth::check()) {
      // registration closed

      $validator = Validator::make($request->all(), [
        'name' => 'required|min:5',
        'staff_id' => 'required|unique:participants,staff_id,NULL,id,deleted_at,NULL',
        'email' => 'required|email',
        'dependant_relationship.*' => 'nullable|required_with:dependant_name.*',
        'dependant_age.*' => 'nullable|required_with:dependant_name.*|numeric',
        ], ['staff_id.unique' => 'Staff Id is already registered.',
          'staff_id.exists' => 'You\'re not member of TM HQ',
          'dependant_age.*.numeric' => 'Please enter number only for age',
          'dependant_age.*.required_with' => 'Dependants\' age is required',
          'dependant_relationship.*.required_with' => 'Please specify relationship'
        ]);

      //if user logged in, rule for TM HQ members only will be bypassed
      $validator->sometimes('staff_id', 'exists:staffs,staff_id', function ($input) {
            return Auth::check() ? false:true;
      });
      
      // registration closed
      }
      else {
        return Redirect::to(URL::previous() . "#registration")->withErrors('Please contact admin for details.')->withInput();
      }
      // registration closed

      if ($validator->fails()) {
        return Redirect::to(URL::previous() . "#registration")->withErrors($validator)->withInput();
      }

      DB::beginTransaction();

      $participant = Participant::create([
        'name' => title_case(request('name')),
        'staff_id' => strtoupper(request('staff_id')),
        'email' => strtolower(request('email')),
        'member' => Member::where('staff_id',strtoupper(request('staff_id')))->count(),
      ]);

      foreach (request('dependant_name') as $key => $value) {
        if (isset($value)){ //check for existance of dependants

          Dependant::create([
          'name' => title_case($value),
          'relationship' => title_case(request('dependant_relationship')[$key]),
          'age' => request('dependant_age')[$key],
          'staff_id' => request('dependant_staff')[$key],
          'participant_id' => $participant->id
          ]);
        }
      };

      if($participant){ //only send email if successfully created
        $this->sendEmail($participant->id);
        DB::commit();
      } else{
        DB::rollBack();
      }

      return redirect()->route('registration_show', ['slug' => $participant->slug()]);

    }

    public function sendEmail($pid = null){

      if (isset($pid)){
        $p = Participant::find($pid);
      } else {
        $p = Participant::find(request()->pid);
      }

      return Mail::to($p->email)->send(new RegistrationConfirmation($p));
    }

    public function delete(Request $request){

        $p = Participant::find($request->pid);
        $p->deleted_by = Auth::user()->id;
        $p->save();

        $p->delete();
        $p->dependants()->delete();
    }

    public function attend($slug){

        $participant = Participant::findBySlugOrFail($slug);

        if($participant->payment_status == 'Pending')
          return view('registration.error')->with('warning', 'No payment info has been captured.');
        if ($participant->count() == 0){//QR code not valid or payment status = Pending
          return view('registration.error')->with('warning', 'QR code not valid or no payment info has been captured.');
        }

        if($participant->attend) {//kalau dah datang
          return view('registration.error')->with('warning', 'QR code already scanned. Please contact commitee for assistance.');
        }
        else{
          $participant->attend = 1;
          $participant->attended_by = Auth::user()->id;
          $participant->attend_timestamp = \Carbon\Carbon::now();
          $participant->save();
        }

        return view('registration.show',compact('participant'));
    }

    public function show($slug){

        $participant = Participant::findBySlug($slug);
        if (!$participant){
          return view('registration.error')->with('warning', 'Registration not found.');
        }

        return view('registration.show',compact('participant'));
    }
}
