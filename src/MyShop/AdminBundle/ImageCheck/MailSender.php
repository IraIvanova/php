<?php


namespace MyShop\AdminBundle\ImageCheck;


class MailSender
{

    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer= $mailer;
    }

    public function sendMail($sendTo, $sendFrom, $content, $type)
    {
        $message = new \Swift_Message();
        $message->setTo($sendTo);
        $message->addFrom($sendFrom);
        $message->setBody($content,$type);


        $this->mailer->send($message);
    }

}