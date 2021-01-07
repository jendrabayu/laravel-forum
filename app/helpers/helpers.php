<?php

use Illuminate\Support\Str;

function  greeting_prepend($name)
{

  $time = (new \Carbon\Carbon())->format('H');
  if ($time < "12") {
    $greetings = "Pagi, ";
  } else if ($time >= "12" && $time < "17") {
    $greetings = "Siang, ";
  } else if ($time >= "17" && $time < "19") {
    $greetings = "Sore, ";
  } else if ($time >= "19") {
    $greetings = "Malam, ";
  } else {
    $greetings = '';
  }

  return $greetings . '' . Str::words($name, 3, '');
}
