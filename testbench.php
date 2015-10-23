<?php
require 'vendor/autoload.php';
require 'library.php';
$authOpts = array(
    'login' => "GONE",
    'password' => "GONE",
    'trace' => 1,   // Allows us to debug by getting the XML requests sent
);
$wsdl = "https://webservices3.autotask.net/atservices/1.5/atws.wsdl";
$client = new ATWS\Client($wsdl, $authOpts);

$me = array(
    "firstname" => "Jacob",
    "lastname" => "Holtom"
);

$response = resourceQuery($client,$me);
$userid = $response->id;
echo '<pre>';
$ticketlist = assignedOpenTicketList($client,$userid);

foreach ($ticketlist as $i){
echo $i->Priority . "\n";
    /*
echo $i->Title;
    $priorityInts[$i->Priority]
    $statusInts[$i->Status]*/
}
echo '</pre>';
?>
