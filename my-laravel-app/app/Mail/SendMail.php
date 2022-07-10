<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $news;
    public $completes;
    public $incompletes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($news, $completes, $incompletes)
    {
        //
        $this->news = $news;
        $this->completes = $completes;
        $this->incompletes = $incompletes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('test@example.com')
            ->subject('タスク状況通知メール')
            ->view('mail.batch', compact('news', 'completes', 'incompletes'));
    }
}
