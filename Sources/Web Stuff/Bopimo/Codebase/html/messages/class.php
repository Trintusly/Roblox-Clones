<?php
require("/var/www/html/site/bopimo.php");
class message extends bopimo {
  public function get ( int $mid )
  {
    $msg = $this->look_for("message", ["id" => $mid]);
    return $msg;
  }
  public function new ( int $to, int $from, string $title, string $body )
  {
    $msg = $this->insert("messages", [
      "to" => $to,
      "from" => $from,
      "title" => $title,
      "body" => $body,
      "time" => time()
    ]);
    return $msg;
  }
}

if(!isset($message))
{
  $message = new message;
}
?>
