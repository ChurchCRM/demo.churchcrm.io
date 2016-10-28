<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$registration = json_decode(file_get_contents('php://input'));
if ($registration->sName)
{
  $sEmailMessage =
    "Church name: " . $registration->sName . "\n\n" .
    "Email: " .$registration->sEmail . "\n\n" .
    "Address: " . $registration->sAddress . "\n" .
    "City: " .$registration->sCity . "\n" .
    "State: " .$registration->sState . "\n" .
    "Zip: " .$registration->sZip . "\n" .
    "Country:  " .$registration->sCountry . "\n\n" .
    "Additional comments: " . $registration->sComments . "\n";

  file_put_contents(__DIR__."/REGISTRATIONS.json", "\n".file_get_contents('php://input'), FILE_APPEND);
  mail( "crossan007@gmail.com,george@dawouds.com ", "ChurchCRM Registration Alert", $sEmailMessage);
}

?>


