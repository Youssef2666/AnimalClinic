<?php

use Illuminate\Support\Facades\Mail;

function sendMail($template, $to, $subject, $data){
    Mail::send($template, $data, function ($message) use ($to, $subject) {
        $message->subject($subject);
        $message->to($to);
    });
}
