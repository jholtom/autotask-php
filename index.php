<?php
require 'vendor/autoload.php';
require 'library.php';
/*
 * Constant Definitions, Relate the integer output of the Autotask API to Human-readable text.
 * Be careful to not overwrite, because we can't have constant arrays in PHP 5.4
 */
$priorityInts = array(
    1 => "High",
    2 => "Medium",
    3 => "Low???"
);
$statusInts = array(
    1 => "Open",
    5 => "Complete"
);
/*
 * $authOpts contains the username and password of the API account at the moment.  This should eventually pull from the log-on screen.
 */
$authOpts = array(
    'login' => "GONE",
    'password' => "GONE",
    'trace' => 1,   // Allows us to debug by getting the XML requests sent - REMOVE
);

/*
 * US East Region WSDL Address.  Change this if it is every moved to another region.  List can be found in the Autotask API Handbook
 */
$wsdl = "https://webservices3.autotask.net/atservices/1.5/atws.wsdl";
/*
 * Starts the Autotask API Client
 */
$client = new ATWS\Client($wsdl, $authOpts);
/*  TODO
 *  Replace this with the login functionality and the current users resourceID
 */
$me = array(
    "firstname" => "Jacob",
    "lastname" => "Holtom"
);
$response = resourceQuery($client,$me);
$userid = $response->id;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>HC/S1/Ark Autotask</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">HC/S1/Ark Autotask</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="#">Tickets</a></li>
            <li><a href="#">Resources</a></li>
            <li><a href="#">KnowledgeBase</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Sign Out</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Tickets</h1>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Account</th>
                  <th>Priority</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <!--<tr>
                  <td>1,015</td>
                  <td>sodales</td>
                  <td>ligula</td>
                  <td>in</td>
                  <td>libero</td>
                  </tr>-->
                <?php
                    $ticketlist = assignedOpenTicketList($client,$userid);
                    foreach ($ticketlist as $i){
                        echo '<tr>';
                        echo '<td>' . $i->TicketNumber . '</td>';
                        echo '<td>' . $i->Title . '</td>';
                        echo '<td>' . accountNameLookup($client,$i->AccountID) . '</td>';
                        echo '<td>' . $priorityInts[$i->Priority] . '</td>';
                        echo '<td>' . $statusInts[$i->Status] . '</td>';
                        echo '</tr>';
                    }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
