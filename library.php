<?php
/**
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

/**
 * This makes a query for a list of Contacts, as well as sanitizing the response from Autotask
 *
 * @return array Returns a useful PHP Array with Information about the Contact
 *
 * @param object $client Takes the client connection object
 *
 * @param array $names Takes an array with either 'firstname' or 'lastname' elements, or both.
 */
function contactQuery($client,$names){
    $query = new ATWS\AutotaskObjects\Query('Contact');
    if(isset($names["firstname"])){
        $firstnameField = new ATWS\AutotaskObjects\QueryField('firstname');
        $firstnameField->addExpression('Equals', $names["firstname"]);
        $query->addField($firstnameField);
    }
    if(isset($names["lastname"])){
        $lastnameField = new ATWS\AutotaskObjects\QueryField('lastname');
        $lastnameField->addExpression('Equals', $names["lastname"]);
        $query->addField($lastnameField);
    }
    $response = $client->query($query);
    if(isset($response->queryResult->EntityResults->Entity)){
        $target = $response->queryResult->EntityResults->Entity;
    }
    else{
        $target = array("UserType" => "NaN");
    }
    return $target;
}
/**
 * This makes a query for a list of Resources, as well as santizing the response from Autotask
 *
 * @return array Returns a useful PHP Array with Information about the Resource
 *
 * @param object $client Takes the client connection object
 *
 * @param array $names Takes an array with either 'firstname' or 'lastname' elements, or both.
 */
function resourceQuery($client, $names){
    $query = new ATWS\AutotaskObjects\Query('Resource');
    if(isset($names["firstname"])){
        $firstnameField = new ATWS\AutotaskObjects\QueryField('firstname');
        $firstnameField->addExpression('Equals', $names["firstname"]);
        $query->addField($firstnameField);
    }
    if(isset($names["lastname"])){
        $lastnameField = new ATWS\AutotaskObjects\QueryField('lastname');
        $lastnameField->addExpression('Equals', $names["lastname"]);
        $query->addField($lastnameField);
    }
    $response = $client->query($query);
    if(isset($response->queryResult->EntityResults->Entity)){
        $target = $response->queryResult->EntityResults->Entity;
    }
    else{
        $target = array("UserType" => "NaN");
    }
    return $target;
}
/*
 * Returns all unassigned Tickets
 * @param Takes the $client connection object
 * @return Returns a PHP Object with the collection of Tickets
 */
function ticketList($client){
    $query = new ATWS\AutotaskObjects\Query('Ticket');
    return $client->query($query); 
}
/**
 * Returns the list of Tickets assigned to the specified Resource
 *
 * @param $client description Takes the $client connection object
 *
 * @param $userID description Takes the ResourceID
 *
 * @return array Returns a PHP Array with the collection of Tickets
 */
function assignedTicketList($client, $userID){
    $query = new ATWS\AutotaskObjects\Query('Ticket');
    $uidField = new ATWS\AutotaskObjects\QueryField('AssignedResourceID');
    $uidField->addExpression('Equals', $userID);
    $query->addField($uidField);
    $response = $client->query($query)->queryResult->EntityResults->Entity;
    if(is_array($response)){
        return $response;
    }
    else{
        return array($response);
    }
}
/**
 * Returns the list of Open Tickets assigned to the specified Resource
 *
 * @param object $client Takes the $client connection object
 *
 * @param integer $userID Takes the resourceID of the assigned Resource
 *
 * @return array Returns a PHP Arrayt with the collection of Tickets
 */
function assignedOpenTicketList($client, $userID){
    $query = new ATWS\AutotaskObjects\Query('Ticket');
    $uidField = new ATWS\AutotaskObjects\QueryField('AssignedResourceID');
    $uidField->addExpression('Equals', $userID);
    $query->addField($uidField);
    $statusField = new ATWS\AutotaskObjects\QueryField('Status');
    $statusField->addExpression('Equals', 1);
    $query->addField($statusField);
    $response = $client->query($query)->queryResult->EntityResults->Entity;
    if(is_array($response)){
        return $response;
    }
    else{
        return array($response);
    }
}
/**
 * Returns the list of Closed Tickets assigned to the specified Resource
 *
 * @param object $client  Takes the $client connection object
 *
 * @param integer $userID Takes the resourceID of the assigned Resource
 *
 * @return array Returns a PHP Array with the collection of Tickets
 */
function assignedCompleteTicketList($client, $userID){
    $query = new ATWS\AutotaskObjects\Query('Ticket');
    $uidField = new ATWS\AutotaskObjects\QueryField('AssignedResourceID');
    $uidField->addExpression('Equals', $userID);
    $query->addField($uidField);
    $statusField = new ATWS\AutotaskObjects\QueryField('Status');
    $statusField->addExpression('Equals', 5);
    $query->addField($statusField);
    $response = $client->query($query)->queryResult->EntityResults->Entity;;
    if(is_array($response)){
        return $response;
    }
    else{
        return array($response);
    }
}
/**
 * Returns a string with the Human-readable name of the Account
 *
 * @param object $client Takes the $client connection object\
 *
 * @param integer $accountID Takes the accounts ID from Autotask
 *
 * @return string Returns a string with the Human-readable name of the Account
 */
function accountNameLookup($client,$accountID){
    $query = new ATWS\AutotaskObjects\Query('Account');
    $aidField = new ATWS\AutotaskObjects\QueryField('id');
    $aidField->addExpression('Equals',$accountID);
    $query->addField($aidField);
    $response = $client->query($query);
    return $response->queryResult->EntityResults->Entity->AccountName;
}
?>
