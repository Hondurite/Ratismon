<?php
 
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
 
// array for JSON response
$response = array();
 
// check for required fields
if (isset($_POST['email']) && isset($_POST['passwort'])) {
 

    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
	$emptyString = "";
	$sex = "Weiblich";
 
    $verbindung = mysql_connect ("87.106.18.104","Markus", "oxx10I!4")or die ("keine Verbindung möglich.Benutzername oder Passwort sind falsch");

	mysql_select_db("Ratismon") or die ("Die Datenbank existiert nicht.");
	
	$result6 = mysql_query("SELECT usernr FROM Anmeldedaten WHERE email LIKE '$email'");
	$count6 =  mysql_num_rows($result6); 
	if($count6 != 0){
		$response["success"] = 2;
		$response["message"] = "Email already registered.";
		$response["email"]= 0; //Email schon eingetragen
		
		echo json_encode($response);
	}else{
	
		// mysql inserting a new row
		$result = mysql_query("INSERT INTO Anmeldedaten(usernr, email, passwort) VALUES(NULL, '$email', '$passwort')");
		$result1 = mysql_query("INSERT INTO Charakterdaten(usernr, charactername, sex, level, exp, strength, stamina, dexterity, intelligence) 
													VALUES(NULL, '$emptyString', '$sex', '1', '0', '15', '15', '15', '15')");
		$result2 = mysql_query("INSERT INTO Charakterweapons(usernr, usedweapon, inv1, inv2, inv3, inv4, inv5, inv6, inv7, inv8, inv9) 
					VALUES(NULL, '1', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString')");
		$result3 = mysql_query("INSERT INTO Charakterbag(usernr, inv1, inv2, inv3, inv4, inv5, inv6, inv7, inv8, inv9, inv10) 
					VALUES(NULL, '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString')");
		$result4 = mysql_query("INSERT INTO Charakterarmor(usernr, usedarmor, inv1, inv2, inv3, inv4, inv5, inv6, inv7, inv8, inv9) 
					VALUES(NULL, '1', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString', '$emptyString')");
		
		$result5 = mysql_query("SELECT usernr FROM Anmeldedaten WHERE email LIKE '$email'");
		$row = mysql_fetch_row($result5);
		// check if row inserted or not
		if ($result && $result1 && $result2 && $result3 && $result4 && result5) {
			// successfully inserted into database
			$response["success"] = 1;
			$response["message"] = "Product successfully created.";
			$response["usernr"]= $row[0];
	 
			// echoing JSON response
			echo json_encode($response);
		} else {
			// failed to insert row
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred.";
	 
			// echoing JSON response
			echo json_encode($response);
		}
	}
	
    
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
	
    // echoing JSON response
    echo json_encode($response);
}
	


?>