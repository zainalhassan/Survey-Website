<?php

// Things to notice:
// You need to add code to this script to implement the admin functions and features
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// You can implement all the admin tools functionality from this script, or...

// execute the header script:
require_once "header.php";

// default values we show in the form:
$username = "";

// strings to hold any validation error messages:
$username_val = "";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else
{
	// only display the page content if this is the admin account (all other users get a "you don't have permission..." message):
	if ($_SESSION['username'] == "admin")
	{
		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        // if the connection fails, we need to know, so allow this exit:
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }

				//grab all data in surveys table
				$query = "SELECT * FROM surveys";

				// this query can return data ($result is an identifier):
				$result = mysqli_query($connection, $query);

				 // how many rows of data come back?
					$n = mysqli_num_rows($result);

				if ($n > 0)
				{
					//table styling
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
						echo "<tr><th>Survey Name</th> <th> Number of Questions </th> <th> Created By </th> </tr>";
						echo "To view additional survey functionality, please go to 'My Surveys' from the header";
						// loop over all rows, adding them into the table:
									for ($i=0; $i<$n; $i++)
									{
											// fetch one row as an associative array (elements named after columns):
											$row = mysqli_fetch_assoc($result);
											// add it as a row in our table:
											echo "<tr>";
											echo "<td>{$row['surveyName']}</td> <td>{$row['numQuestions']}</td> <td>{$row['usernameCreated']}</td> ";
											echo "</tr>";
									}
									echo "</table>";
						}
						else
				        {
				            // no users found...:
				            echo " <br> no users found<br>";
				        }

		//show all users apart from admin in the table
		$query = "SELECT username from users WHERE username != 'admin'";
		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);

		 // how many rows of data come back?
    $n = mysqli_num_rows($result);

		if ($n > 0)
		{
			//table styling
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
			echo "<tr><th>User's username</th> </tr>";
			//loop through and insert a username to each table row, which is hyperlinked, takes you to view all of user's info
			for ($i=0; $i<$n; $i++)
			{
				$row = mysqli_fetch_assoc($result);
				echo "<tr>";
				echo "<td> <a href='userDetails.php?username={$row['username']}' '>" . "{$row['username']}" . "</a> </td>";
				echo "</tr>";
			}
        echo "</table>";
		}
		else
    {
      // no users found...:
      echo "no users found<br>";
    }

		echo <<<_END
		<!-- delete a user by inputting the username and pressing button -->
		<form action="admin.php" method="POST">
			<label> Input username and click button to delete their account </label>
			<input type = "text" name = "usernameDelete">
			<button name="usernameDeleteButton" type="submit" value="delete" required>Delete</button>
		</form>

<br>
		<!-- insert a new user -->
		<form action="insert.php">
			<button name="insertAccountButton" type="submit" value="insert">Insert Account</button>
		</form>

		<br>
		<!-- update exsting user account -->
		<form action="update.php">
			<button name="updateAccountButton" type="submit" value="update">Update Account</button>
		</form>

		<br>
		<!-- change password ny inputting username -->
		<form action="changePassword.php">
			<button name="changePasswordButton" type="submit" value="change">Change Password</button>
		</form>
_END;
		//if delete button is pressed, perform queries to delete user
		if(isset($_POST['usernameDeleteButton']))
		{
			$query = "DELETE FROM users WHERE username = '{$_POST['usernameDelete']}'";

			$result = mysqli_query($connection, $query);
			if($result)
			{
				header ("Location: " . $_SERVER['PHP_SELF']);
				echo "<br>";
				echo "Account deleted";
				echo "<br>";
			}
			else
			{
				echo "Account not deleted";
			}
		}
		// we're finished with the database, close the connection:
    mysqli_close($connection);
	}
	else
	{
		echo "You don't have permission to view this page...<br>";
	}
}
// finish off the HTML for this page:
require_once "footer.php";
?>
