<?php

namespace App\Mail;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Post $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.postRegistered')
        ->subject("ثبت نام در ". $this->post->getPostType('fa') . str_replace($this->post->getPostType('fa'),'',$this->post->title) );
    }
}
