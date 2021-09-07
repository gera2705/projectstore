<?php

namespace App\Jobs;

use App\Mail\ApprovalProjectMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApprovalMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $supervisorEmail; // E-mail руководителя
    public $project; // найденный проект

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($supervisorEmail,$project)
    {
        $this->supervisorEmail = $supervisorEmail;
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->supervisorEmail)->send(new ApprovalProjectMail($this->project)); // в send'e email-строитель
    }
}
