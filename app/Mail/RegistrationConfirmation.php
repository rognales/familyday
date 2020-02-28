<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Participant;

class RegistrationConfirmation extends Mailable
{
  use Queueable, SerializesModels;

  public $participant;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct(Participant $participant)
  {
    $this->participant = $participant;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->subject('Kelab Ibu Pejabat - Family Day 2020 Registration Confirmation')
      ->view('registration.litmus');
  }
}
