<?php
require 'vendor/autoload.php';
require 'library.php';
/*
 * Initialize new Slim app for the REST API
 */
$app = new \Slim\Slim();

/*
 *
 *
 *
 */
$app->get('/tickets/:uid', function ($uid)
{
    assignedOpenTicketList(,$uid);
    echo
}
);


//Execute API!
$app->run();
?>