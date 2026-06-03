<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\LaporanInfrastruktur;

class LaporanMasukNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $laporan;

    public function __construct(LaporanInfrastruktur $laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id_laporan' => $this->laporan->id,
            'tracking_id' => $this->laporan->tracking_id,
            'daerah' => $this->laporan->daerah->nama_daerah ?? 'Tidak diketahui',
            'tipe' => 'laporan'
        ];
    }
}
