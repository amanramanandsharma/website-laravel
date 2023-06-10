<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mails\UserPostsEmail;
use Mail;
use DB;

class SendEmailToUserAboutPost implements ShouldQueue
{
    /**
     * Create the event listener.
     */

    use InteractsWithQueue;
    public $tries = 2;

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
            $mail_data->put('title', $event->post['title']);
            $mail_data->put('description', $event->post['description']);
            
            $email = new UserPostsEmail($mail_data);
            Mail::to($event->post['email'])->send($email);

            DB::table('posts_users')->insert([
                'user_id'=> $request->description,
                'post_id' =>  $request->title,
                'success'=> 1,
            ]);

        }catch(\Exception $e){
             DB::table('posts_users')->insert([
                'user_id'=> $request->description,
                'post_id' =>  $request->title,
                'success'=> 0,
            ]);
        }
        
    }
}
