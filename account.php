<?php

// Things to notice:
// The main job of this script is to execute a SELECT statement to find the user's profile information (then display it)

// execute the header script:
require_once "header.php";

//hash of Password
$preSalt = "My2Mu8";
$postSalt = "9Phdt2";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else
{
    // user is already logged in, read their username from the session:
	$username = $_SESSION["username"];

	// now read their account data from the table...
	// connect directly to our database (notice 4th argument):
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	$query = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";

	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);

	 // how many rows of data come back?
			$n = mysqli_num_rows($result);

	if ($n > 0)
	{
		//style of table
		echo <<<_END
		<style>
					table, th, td {border: 1px solid black; align: center;}

							th, td {
							text-align: left;
							padding: 8px;
					}

					tr:nth-child(even){background-color: #c5c9c8}

					th {
							background-color: #23c4a4;
							color: black;
					}


		</style>
_END;

		echo "<table cellpadding = '2' cellspacing = '2'>";
	// loop over all rows, adding them into the table:
					for ($i=0; $i<$n; $i++)
					{
							// fetch one row as an associative array (elements named after columns):
							$row = mysqli_fetch_assoc($result);
							// add it as a row in our table:
							echo "<tr> <th> First Name</th> <td> {$row['firstName']} </td> </tr>";
							echo "<tr> <th> Last Name</th> <td> {$row['lastName']} </td> </tr>";
							echo "<tr> <th> Username</th> <td>{$row['username']}</td> </tr>";
							echo "<tr> <th> Password</th> <td>{$row['password']}</td> </tr>";
							echo "<tr> <th> Email </th> <td>{$row['email']}</td> </tr>";
							echo "<tr> <th> Date of Birth </th> <td>{$row['dob']}</td> </tr>";
							echo "<tr> <th> Telephone </th> <td>{$row['telephone']}</td> </tr>";
						}
					echo "</table> <br>";
				}
					else
		 		{
		 			// no match found, prompt user to set up their profile:
		 			echo "You still need to set up a profile!<br>";
		 		}

	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM users WHERE username='$username'";

	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);

	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($result);

	// if there was a match then extract their profile data:
	if ($n > 0)
	{
		// use the identifier to fetch one row as an associative array (elements named after columns):
		$row = mysqli_fetch_assoc($result);
		// display their profile data:


		$password = $row['password'];
		echo "Hashed Password: " . $password = sha1($preSalt . $password . $postSalt) . "<br>";
	}
	else
	{
		// no match found, prompt user to set up their profile:
		echo "You still need to set up a profile!<br>";
	}

	// we're finished with the database, close the connection:
	mysqli_close($connection);

}

// finish off the HTML for this page:
require_once "footer.php";
?>
