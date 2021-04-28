<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoverLetter;
use App\Models\Conversation;
use App\Models\Proposal;
use App\Models\Message;
use App\Models\Job;

class ProposalController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $proposal = Proposal::create([
            'job_id' => $job->id,
            'validated' => false
        ]);

        CoverLetter::create([
            'proposal_id' => $proposal->id,
            'content' => $request->input('content')
        ]);

        return redirect()->route('jobs.index');
    }

    public function comfirm(Request $request)
    {
        $proposal = Proposal::findOrFail($request->proposal);
        $proposal->fill(['validated' => 1]);

        if ($proposal->isDirty()) {
            # code...
            $proposal->save();

            $conversation = Conversation::create([
                'from' => auth()->user()->id,
                'to' => $proposal->user->id,
                'job_id' => $proposal->job_id
            ]);

            Message::create([
                'user_id' => auth()->user()->id,
                'conversation_id' => $conversation->id,
                'content' => "Bonjour, j'ai validé votre offre."
            ]);
            
            return redirect()->route('jobs.index');
        }
    }
}
