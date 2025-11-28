<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     */
    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->chat->receiver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }

    // ブロードキャスト用JSON作成
    public function broadcastWith()
    {
        return [
            'id' => $this->chat->id,
            'item_id' => $this->chat->item_id,
            'body' => $this->chat->body,
            'sender_id' => $this->chat->sender_id,
            'receiver_id' => $this->chat->receiver_id,
            'created_at' => $this->chat->created_at->toDateTimeString(),
            'chat_images' => $this->chat->chatImages
                ? $this->chat->chatImages->map(fn ($img) => asset('storage/'.$img->chat_image))
                : [],
        ];
    }
}
