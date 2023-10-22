<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Twieaq extends Mailable
{
    use Queueable, SerializesModels;

    public $name ,$email,$message,$phone;
    /**
     * Create a new message instance.
     */
    public function __construct($name,$email,$message,$phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message  = $message;
        $this->phone  = $phone;
      //  $this->file=$file;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:'',
            from:$this->email,
            
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            markdown: 'Emails',

            with: [
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message,
                'phone' => $this->phone,
            ],
        );
    }

    // public function build()
    // {
    //     $message = $this->view('Emails')
    //               ->with([
    //                             'name' => $this->name,
    //                              'email' => $this->email,
    //                              'message' => $this->message,
    //                             'phone' => $this->phone,
    //                          ]);

    //     if ($this->file) {
    //         $message->attach($this->file->getRealPath(), [
    //             'as' => $this->file->getClientOriginalName(),
    //             'mime' => $this->file->getClientMimeType(),
    //         ]);
    //     }

    //     return $message;
    // }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
