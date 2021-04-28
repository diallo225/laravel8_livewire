<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

   

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Conversation  $conversation
     * @return mixed
     */
    public function view(User $user, Conversation $conversation)
    {
        if ($user->id == $conversation->job->user_id) {
            # code...
            return $conversation->from == $conversation->job->user_id;
        }else {
            # code...
            return $user->proposals->contains(function ($value, $key) use ($conversation, $user){
                return $value['validated'] == 1
                && $value['job_id'] == $conversation->job->id
                && $conversation->to == $user->id;
            });
        }
    }

}
