<?php
namespace Base;

class Email {

   public function send(string $to, string $subject, string $message, string $from) {

      $headers  = "Content-type: text/html; charset=utf-8 \r\n";
      $headers .= "From: <{$from}>\r\n";

      mail($to, $subject, $message, $headers);
   }
}