<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Participant;

class ParticipantEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $p = Participant::find($request->input('pid'));
        if ($p){
            $p->sendConfirmationEmail();
        }
    }
}
