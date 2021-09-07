<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->project->error_message) {
            return $this->view('emails.approval', ['project' => $this->project])
                ->subject('Ваш проект не прошел проверку');

        }
        else {
            return $this->view('emails.approval', ['project' => $this->project])
                ->subject('Ваш проект одобрен');
        }
    }
}
