<?php

namespace App\Jobs;

use App\Mail\ApprovalProjectMail;
use App\Mail\CreatedProjectMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendProjectCreatedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $admins_email; // E-mail руководителя
    public $project; // найденный проект
    public $supervisor; // руководитель

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($project, $admins_email, $supervisor)
    {
        $this->admins_email = $admins_email;
        $this->project = $project;
        $this->supervisor = $supervisor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->admins_email as $email) {
            Mail::to($email)->send(new CreatedProjectMail($this->project,$this->supervisor));
        }
    }
}
