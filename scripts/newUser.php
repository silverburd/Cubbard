<?php
include("../scripts/functions.php");
$firstName = $_POST['fname'];
$lastName = $_POST['lname'];
$email = $_POST['email'];
$emailConfirm = $_POST['emailConfirm'];
$password = $_POST['password'];

// Check if all data is entered
if (!$firstName || !$lastName || !$email || !$emailConfirm || !$password) {
	echo "All data was not submited";
	exit;
}
if ($email != $emailConfirm) {
	echo "Emails did not match.";
	exit;
}
// Add slashes to prevet mysql hacking
if (!get_magic_quotes_gpc) {
	addslashes($firstName);
	addslashes($lastName);
	addslashes($email);
	addslashes($password);
}
$password = md5($password.$salt);
// check to see if email already exsisits
$checkEmail = $db->query("SELECT COUNT(*) FROM users WHERE email = '".$email."'");
if (!$checkEmail) {
	$status = "Could not update database.";
	exit;
}
$row = mysqli_fetch_row($checkEmail);
$count = $row[0];

// if email exsists create error
if ($count > 0) {
	$status = "Email already in use.";
	exit;
}

// if everything passes insert data in to users table
$query = "INSERT INTO users VALUES ('', '".$firstName."', '".$lastName."', '".$email."', '".$password."')";
$result = $db->query($query);

if($result) {
	header('Location: ../public/account.php');
} else {
	echo "An error occured. Please try again.";
}
?>
