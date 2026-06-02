<?php

namespace App\Events;

use App\Models\LaporanInfrastruktur;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LaporanMasukEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $laporan;

    /**
     * Create a new event instance.
     */
    public function __construct(LaporanInfrastruktur $laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('laporan.masuk.' . $this->laporan->id_daerah),
            new PrivateChannel('laporan.masuk.semua'),
        ];
    }
    
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->laporan->id,
            'tracking_id' => $this->laporan->tracking_id,
            'daerah' => $this->laporan->daerah->nama_daerah ?? 'Tidak diketahui',
            'latitude' => $this->laporan->latitude,
            'longitude' => $this->laporan->longitude,
            'pesan' => 'Ada laporan infrastruktur baru masuk!'
        ];
    }
}
