<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $candidate;
    protected $project;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project,$candidate)
    {
        $this->project = $project;
        $this->candidate = $candidate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome',['project'=>$this->project,'candidate'=>$this->candidate])
            ->subject('[ЯП] Заявка на "'.$this->project->title.'"');
    }
}
