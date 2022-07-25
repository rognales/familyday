<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;

class ParticipantEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$request->has('type')) {
            return;
        }

        $participant = Participant::whereId($request->input('pid'))->first();

        if (!$participant) {
            return;
        }

        if ($request->type == 'registration') {
            $participant->sendConfirmationEmail();
        }

        if ($request->type == 'payment') {
            $participant->sendPaymentConfirmationEmail();
        }

        return 'Email queued for sending. You should be getting it in a moment.';
    }
}
