<?php

namespace App\Events;

use App\Http\Resources\File\ContentFileChunkResource;
use App\Http\Resources\File\ContentFileResource;
use App\Models\ExcelFile;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Queue\SerializesModels;

class TableImported implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private ExcelFile $file;
    private array $data;

    /**
     * Create a new event instance.
     */
    public function __construct(ExcelFile $file, array $data)
    {
        $this->file = $file;
        $this->data = $data;
    }

    public function broadcastAs(): string
    {
        return 'table.imported';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('table.imported.' . $this->file->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith()
    {
        return $this->data;
    }
}
