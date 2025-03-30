<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    public function build()
    {
        return $this->subject("You're Invited to Join " . $this->invitation->company->name)
                    ->view('emails.invite')
                    ->with([
                        'companyName' => $this->invitation->company->name,
                        'role' => $this->invitation->role,
                        'inviteLink' => url("api/invited/" . $this->invitation->token),
                    ]);
    }
}

