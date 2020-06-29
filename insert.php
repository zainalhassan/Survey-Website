<?php
require_once "header.php";

$user = $_SESSION['username'];

$dateRestriction = date ("Y-m-d");
// default values we show in the form:
$insertUsername = "";
$insertPassword = "";
$insertEmail = "";
$insertFirstName = "";
$insertLastName = "";
$insertDob = "";
$insertTelephone = "";

// strings to hold any validation error messages:
$insertUsername_val = "";
$insertPassword_val = "";
$insertEmail_val = "";
$insertFirstName_val = "";
$insertLastName_val = "";
$insertDob_val = "";
$insertTelephone_val = "";

// should we show the signup form?:
$show_signup_form = false;
// message to output to user:
$message = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user is already logged in, just display a message:
	echo "You need to be logged in to view this page<br>";
}
elseif (isset($_POST['username'])) //not sure if this goes in admin.php or not
{
	// user just tried to sign up:

	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

	// SANITISATION (see helper.php for the function definition)

	// take copies of the credentials the user submitted, and sanitise (clean) them:
	$insertUsername = sanitise($_POST['username'], $connection);
	$insertPassword = sanitise($_POST['password'], $connection);
  $insertEmail = sanitise($_POST['email'], $connection);
	$insertLastName = sanitise($_POST['lastName'], $connection);
	$insertFirstName = sanitise($_POST['lastName'], $connection);
	$insertDob = sanitise($_POST['dob'], $connection);
	$insertTelephone = sanitise($_POST['telephone'],$connection);


	// VALIDATION (see helper.php for the function definitions)

	// now validate the data (both strings must be between 1 and 16 characters long):
	// (reasons: we don't want empty credentials, and we used VARCHAR(16) in the database table for username and password)
	$insertUsername_val = validateString($insertUsername, 1, 16);
	$insertPassword_val = validateString($insertPassword, 1, 16);
  //the following line will validate the email as a string, but maybe you can do a better job...
  $insertEmail_val = validateString($insertEmail, 1, 64);
	$insertFirstName_val = validateString($insertFirstName,1, 20);
	$insertLastName_val = validateString($insertLastName,1,30);
	$insertDob_val = validateString($insertDob,10,10);
	$insertTelephone_val = validateString($insertTelephone,1,16);

	// concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
	$errors = $insertUsername_val . $insertPassword_val . $insertEmail_val . $insertFirstName_val . $insertLastName_val . $insertDob_val . $insertTelephone_val . $insertTelephone_val;

	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{
		// try to insert the new details:
		$query = "INSERT INTO users (firstName, lastName, username, password, email, dob, telephone) VALUES ('$insertFirstName', '$insertLastName', '$insertUsername', '$insertPassword', '$insertEmail', '$insertDob', '$insertTelephone');";

		$result = mysqli_query($connection, $query);

		// no data returned, we just test for true(success)/false(failure):
		if ($result)
		{
			// show a successful signup message:
			$message = "Row inserted successfully, new user has been created<br>";

			//button to take admin back to admin tools page & button to add new user
			echo <<<_END
			<form action="admin.php">
				<button name="adminReturnButton" type="submit" value="return">Return to Admin tools</button>
			</form>

			<form action="insert.php">
				<button name="addAnotherUserButton" type="submit" value="return">Add another user</button>
			</form>
_END;
		}
		else
		{
			// show the form:
			$show_signup_form = true;
			// show an unsuccessful signup message:
			$message = "Sign up failed, please try again<br>";
		}

	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_signup_form = true;
		// show an unsuccessful signin message:
		$message = "insert failed, please check the errors shown above and try again<br>";
	}

	// we're finished with the database, close the connection:
	mysqli_close($connection);

}
else
{
	// just a normal visit to the page, show the signup form:
	$show_signup_form = true;
}

if ($show_signup_form)
{
// show the form that allows users to sign up
// Note we use an HTTP POST request to avoid their password appearing in the URL:
echo <<<_END
<form action="insert.php" method="POST">
  Please enter details of the new user here :<br>
  Username: <input type="text" name="username" minlength = "1" maxlength="16" value="$insertUsername" required> $insertUsername_val
  <br>
  Password: <input type="password" name="password" minlength = "6" maxlength="16" value="$insertPassword" required> $insertPassword_val
  <br>
  Email: <input type="email" name="email" minlength = "1" maxlength="64" value="$insertEmail" required> $insertEmail_val
  <br>
  First Name: <input type="text" name="firstName" minlength = "1" maxlength="20" value="$insertFirstName" required> $insertFirstName_val
  <br>
  Last Name: <input type="text" name="lastName" minlength = "1" maxlength="30" value="$insertLastName" required> $insertLastName
  <br>
  Date of Birth: <input type="date" name="dob" maxlength = "10" max = "$dateRestriction" value="$insertDob" required> $insertDob_val
  <br>
  Telephone: <input type="telephone" name="telephone" minlength = "1" maxlength="16" value="$insertTelephone" required> $insertTelephone_val
  <br>
  <input type="submit" value="Submit">
</form>

<form action="admin.php">
	<button name="adminReturnButton" type="submit" value="return">Return to Admin tools</button>
</form>
_END;
}
// display our message to the user:
echo $message;
// finish off the HTML for this page:
require_once "footer.php";
?>
