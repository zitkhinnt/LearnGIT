<?php

namespace Modules\Horserace\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
  use Queueable, SerializesModels;

  public $title;
  public $mail_from_address;
  public $mail_from_name;
  public $subject;
  public $body;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->mail_from_address = $data['mail_from_address'];
    $this->mail_from_name = $data['mail_from_name'];
    $this->subject = $data['mail_title'];
    $this->body = nl2br($data['mail_body']);
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('horserace::backend.mail_send.content_mail_send')
      ->from($this->mail_from_address, $this->mail_from_name)
      ->subject($this->subject);
  }
}
