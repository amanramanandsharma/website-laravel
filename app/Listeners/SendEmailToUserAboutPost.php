<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mails\UserPostsEmail;
use Mail;


class SendEmailToUserAboutPost implements ShouldQueue
{
    /**
     * Create the event listener.
     */

    use InteractsWithQueue;
    public $tries = 5;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {

        try{
            $mail_data = collect([]);
            $mail_data->put('title', $event->post->title);
            $mail_data->put('description', $event->post->description);
            $mail_data->put('email', $event->post->email);
            
            $email = new UserPostsEmail($mail_data);
            Mail::to($event->post->email)->send($email);

           }catch(\Exception $e){
            
        }
        
    }
}
