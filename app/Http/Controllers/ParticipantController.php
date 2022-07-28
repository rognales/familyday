<?php

namespace App\Http\Controllers;

use App\Actions\CreateParticipantAction;
use App\Actions\DeleteParticipantAction;
use App\Http\Requests\CreateParticipantRequest;
use App\Http\Requests\DeleteParticipantRequest;
use App\Participant;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

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

        $participant->sendConfirmationEmail();

        return redirect()->route('registration_show', ['slug' => $participant->slug()]);
    }

    public function delete(DeleteParticipantRequest $request, DeleteParticipantAction $action)
    {
        return $action->handle($request->validated(), $request->user());
    }

    public function attend($slug)
    {
        $eventDay = Carbon::parse(config('familyday.eventday'));
        if (now()->isBefore($eventDay)) {
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
            return view('registration.error')->with([
                'warning' => 'QR code already scanned. Please contact commitee for assistance.',
                'participant' => $participant,
            ]);
        }

        $participant->markAttendance();

        return view('registration.show', compact('participant'));
    }

    public function show($slug)
    {
        $participant = Participant::findBySlug($slug);

        if (! $participant) {
            return response()->view('registration.error', ['warning' => 'Registration not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->view('registration.show', ['participant' => $participant->load('uploads')]);
    }
}
