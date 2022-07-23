<?php

namespace App\Http\Controllers;

use App\Member;
use Carbon\Carbon;
use App\Participant;
use Illuminate\Http\Request;
use App\Actions\CreateFormAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Actions\CreateParticipantAction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegistrationIsConfirmed;
use App\Http\Requests\CreateParticipantRequest;
use App\Mail\RegistrationConfirmation;

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

    public function store(CreateParticipantRequest $request, CreateParticipantAction $action)
    {
        $participant = $action->handle($request->validated());

        // Notification::send($participant, new RegistrationIsConfirmed($participant));
        $participant->sendConfirmationEmail();

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
        $participant = Participant::findBySlug($slug)->load('uploads');
        if (! $participant) {
            return view('registration.error')->with('warning', 'Registration not found.');
        }

        return view('registration.show', compact('participant'));
    }
}
