<?php

namespace App\Jobs;

use App\Mail\PostRegistered;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $send_mail;
    protected $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_mail,$post)
    {
        $this->send_mail = $send_mail;
        $this->post = $post;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         // Send Mail To User
         Mail::to($this->send_mail)->send(new PostRegistered(getCurrentUser(),$this->post));
    }
}
