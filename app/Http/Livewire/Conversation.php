<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Conversation extends Component
{
    use AuthorizesRequests;


    public $conversation;
    public $message;
    protected $listeners = ['sent' => '$refresh'];

    public function mount($conversation)
    {
        $this->conversation =  $conversation;
        $this->authorize('view', $conversation);
    }

    public function sendMessage()
    {
        Message::create([
            'user_id' => auth()->user()->id,
            'conversation_id' => $this->conversation->id,
            'content' => $this->message
        ]);

        $this->reset('message');
        $this->emit('sent');
    }
    public function render()
    {
        return view('livewire.conversation');
    }
}
