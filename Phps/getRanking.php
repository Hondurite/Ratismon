<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['email'])) {
 

    $email = $_POST['email'];
 
    $verbindung = mysql_connect ("87.106.18.104","Markus", "oxx10I!4")or die ("keine Verbindung möglich.Benutzername oder Passwort sind falsch");

	mysql_select_db("Ratismon") or die ("Die Datenbank existiert nicht.");
	
	//getUsernr
	
	$result = mysql_query("SELECT usernr FROM Anmeldedaten WHERE email LIKE '$email'");
	$usernr = mysql_fetch_row($result);
	
	
	$result1 = mysql_query("SELECT usernr, charactername, level, exp, @curRank := @curRank + 1 AS rank FROM Charakterdaten p, (SELECT @curRank := 0) r ORDER BY exp DESC");
	
	
 
    // mysql inserting a new row
	
	// check if row inserted or not
    if (!empty($result1)) {
		
		while ($row = mysql_fetch_assoc($result1)) {
			// temp user array
			$response["rank"][] = $row;
		}
		
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Product successfully created.";
		$response["usernr"] = $usernr[0];
 
        // echoing JSON response
        echo json_encode($response);
    } else {
		 // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";    
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
	
    // echoing JSON response
    echo json_encode($response);
}
	


?>