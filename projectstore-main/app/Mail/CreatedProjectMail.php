<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $project;
    protected $supervisor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project, $supervisor)
    {
        $this->project = $project;
        $this->supervisor = $supervisor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.project_created',['project'=>$this->project,'supervisor'=>$this->supervisor])
            ->subject('[ЯП] Создание проекта от "'.preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $this->supervisor->fio).'"');
    }
}
