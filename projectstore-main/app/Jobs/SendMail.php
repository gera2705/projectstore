<?php

namespace App\Jobs;

use App\Mail\CandidateOrderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $supervisorEmail;
    public $project;
    public $candidate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($supervisorEmail,$project,$candidate)
    {
        $this->supervisorEmail = $supervisorEmail;
        $this->project = $project;
        $this->candidate = $candidate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->supervisorEmail)->send(new CandidateOrderMail($this->project,$this->candidate));
        // в send'e email-строитель
    }
}
