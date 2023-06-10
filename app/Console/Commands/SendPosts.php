<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Tenant;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

use App\Models\Central\Apptenant;
use App\Models\Marketplace\Mkptenants;
use App\Models\Marketplace\Mkptenantdetails;

class SendPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send new Posts to all the users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // check all the websites their subscribers and the posts
        $posts_not_sent_to_users = DB::table('posts_users')->where('success',0)->all();
        $posts = [];
        $users = [];

        // Create an array for all the users and posts that have failed
        foreach ($posts_not_sent_to_users as $key => $value) {
            array_push($posts, $value->post_id);
            array_push($users, $value->user_id);
        }

        // Get all the data from the DB - only getting the users and the posts that have failed
        $all_posts = DB::table('posts')->whereIn('id',$posts)->get();
        $all_users_email = DB::table('users')->whereIn('id',$users)->get();

        //Loop over the arrays and send the emails to the users
        foreach ($posts_not_sent_to_users as $key => $value) {
            foreach ($all_posts as $each_post) {
                foreach ($all_users_email as $user) {
                    if($value->post_id == $each_post->id && $value->user_id == $user->id){

                        $data = collect([]);
                        $data->put('title', $each_post->title);
                        $data->put('description', $each_post->description);
                        $data->put('website_id', $each_post->website_id);
                        $data->put('email', $user->email);
                        PostCreated::dispatch($data);
                        break;
                    }
                }
            }
        }

        return Command::SUCCESS;
    }
}