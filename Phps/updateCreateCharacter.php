<?php
 
/*
 * Following code will update a product information
 * A product is identified by product id (usernr)
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['usernr']) && isset($_POST['charactername']) && isset($_POST['sex']) && isset($_POST['usedweapon'])) {
 
    $usernr = $_POST['usernr'];
    $charactername = $_POST['charactername'];
    $sex = $_POST['sex'];
    $usedweapon = $_POST['usedweapon'];
	
	
	$verbindung = mysql_connect ("87.106.18.104","Markus", "oxx10I!4")or die ("keine Verbindung möglich.Benutzername oder Passwort sind falsch");

	mysql_select_db("Ratismon") or die ("Die Datenbank existiert nicht.");
 
    // mysql update row with matched usernr
    $result = mysql_query("UPDATE Charakterdaten SET charactername = '$charactername', sex = '$sex' WHERE usernr LIKE $usernr");
	$result1 = mysql_query("UPDATE Charakterweapons SET usedweapon = $usedweapon WHERE usernr LIKE $usernr");
	$result2 = mysql_query("SELECT * FROM Waffen WHERE weaponnr LIKE $usedweapon");
	
    // check if row inserted or not
    if ($result && $result1) {
        // successfully updated
				while ($row = mysql_fetch_assoc($result2)) {
			// temp user array
			$response["waffen"][] = $row;
		}
		
		
        $response["success"] = 1;
        $response["message"] = "Product successfully updated here.";
		
 
        // echoing JSON response
        echo json_encode($response);
    } else {
 
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
    // echoing JSON response
    echo json_encode($response);
}
?>