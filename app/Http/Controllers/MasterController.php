<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\UsersWebsiteRequest;
use App\Events\PostCreated;
use DB;


class MasterController extends Controller
{
    public function createPost(PostStoreRequest $request)
    {
        $post = DB::table('posts')->insert([
                                'title' =>  $request->title,
                                'description'=> $request->description,
                                'website_id'=> $request->website_id,
                            ]);
        
        $data = collect([]);
        $data->put('title', $request->title);
        $data->put('description', $request->description);
        $data->put('website_id', $request->website_id);
        

        // Check all the users that have subscribed to this website
        $users = DB::table('website_users')->where('website_id',$request->website_id)->pluck('user_id');

        // Send email to all those user
        $user_emails = DB::table('users')->whereIn('id', $users)->pluck('email');

        // loop over and send email for post
        foreach ($user_emails as $key => $value) {
            $data->put('email', $value);
            PostCreated::dispatch($data);
        }
        
        return response()->json(['success' => $post], 200);
    }
    
    public function subscribeUser(UsersWebsiteRequest $request)
    {
        $response = "";

        $existingEntry = DB::table('website_users')
                                ->where('user_id', $request->user_id)
                                ->where('website_id', $request->website_id)
                                ->get();

        // Other checks can be like if the user-id exists or the website-id exists
        if(sizeof($existingEntry)>0){
            $response = "User already Subscribed to website";
        }else{
           DB::table('website_users')->insert([
                'user_id' =>  $request->user_id,
                'website_id'=> $request->website_id,
            ]);

            $response = "User Subscribed to website";
        }

        return response()->json(['success' => $response], 200);
    }
}