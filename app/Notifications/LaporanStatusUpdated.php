<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaporanStatusUpdated extends Notification
{
    use Queueable;

    protected $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Status Laporan Diperbarui')
            ->greeting('Halo!')
            ->line('Status laporan untuk program "' . $this->laporan->program->name . '" telah diperbarui.') // Menggunakan nama program
            ->line('Status baru: ' . $this->laporan->status);

        // Tambahkan alasan penolakan jika status Ditolak
        if ($this->laporan->status === 'Ditolak') {
            $message->line('Alasan Penolakan: ' . $this->laporan->alasan_penolakan);
        }

        return $message->line('Terima kasih!');
    }
}