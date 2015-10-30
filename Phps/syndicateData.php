<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['email']) && isset($_POST['level']) && isset($_POST['exp']) && isset($_POST['stamina']) && isset($_POST['strength']) && isset($_POST['dexterity']) && isset($_POST['intelligence'])) {
 

    $email = $_POST['email'];
	$level = $_POST['level'];
	$exp = $_POST['exp'];
	$stamina = $_POST['stamina'];
	$strength = $_POST['strength'];
	$dexterity = $_POST['dexterity'];
	$intelligence = $_POST['intelligence'];
	
 
    $verbindung = mysql_connect ("87.106.18.104","Markus", "oxx10I!4")or die ("keine Verbindung möglich.Benutzername oder Passwort sind falsch");

	mysql_select_db("Ratismon") or die ("Die Datenbank existiert nicht.");
	
	
 
    // mysql inserting a new row
	
	$result = mysql_query("SELECT usernr FROM Anmeldedaten WHERE email LIKE '$email'");
	$usernr = mysql_fetch_row($result);
	
	$result1 = mysql_query("UPDATE Charakterdaten SET level = '$level', exp = '$exp', stamina = '$stamina', strength = '$strength', dexterity = '$dexterity', intelligence = '$intelligence' WHERE usernr LIKE '$usernr[0]'");
	// check if row inserted or not
    if ($result1) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Product successfully created.";
		$response["usernr"]= $usernr[0];
 
        // echoing JSON response
        echo json_encode($response);
    } else {
		 // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
		$response["usernr"] = 0;    
 
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