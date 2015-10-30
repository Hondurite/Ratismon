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
	
	
 
    // mysql inserting a new row
	
	$result = mysql_query("SELECT usernr FROM Anmeldedaten WHERE email LIKE '$email'");
	$result1 = mysql_query("SELECT passwort FROM Anmeldedaten WHERE email LIKE '$email'");
	$passwort = mysql_fetch_row($result1);
	$usernr = mysql_fetch_row($result);
	// check if row inserted or not
    if ($usernr[0] != null) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Product successfully created.";
		$response["usernr"]= $usernr[0];
		$response["passwort"]= $passwort[0];
 
        // echoing JSON response
        echo json_encode($response);
    } else {
		 // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
		$response["usernr"] = 0;  //Email Wrong       
 
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