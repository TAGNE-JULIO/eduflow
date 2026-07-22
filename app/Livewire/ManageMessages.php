<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;

class ManageMessages extends Component
{
    public $activeTab = 'inbox'; // inbox, sent, compose, read
    public $subject;
    public $body;
    public $receiver_id;
    
    public $viewMessage;

    public function mount()
    {
        $this->activeTab = 'inbox';
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->viewMessage = null;
    }

    public function sendMessage()
    {
        $this->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver_id,
            'subject' => $this->subject,
            'body' => $this->body,
        ]);

        $this->reset(['receiver_id', 'subject', 'body']);
        session()->flash('success', 'Message sent successfully!');
        $this->setTab('sent');
    }

    public function readMessage($messageId)
    {
        $message = Message::with(['sender', 'receiver'])->findOrFail($messageId);
        
        if ($message->receiver_id !== auth()->id() && $message->sender_id !== auth()->id()) {
            abort(403);
        }

        if ($message->receiver_id === auth()->id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        $this->viewMessage = $message;
        $this->activeTab = 'read';
    }

    public function render()
    {
        $inbox = Message::with('sender')->where('receiver_id', auth()->id())->orderBy('created_at', 'desc')->get();
        $sent = Message::with('receiver')->where('sender_id', auth()->id())->orderBy('created_at', 'desc')->get();
        
        // For selecting a receiver
        $users = User::where('id', '!=', auth()->id())->orderBy('name')->get();

        return view('livewire.manage-messages', compact('inbox', 'sent', 'users'))
            ->layout('layouts.app');
    }
}
