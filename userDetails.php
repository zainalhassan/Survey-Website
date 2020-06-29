<?php

// Things to notice:
// You need to add code to this script to implement the admin functions and features
// Notice that the code not only checks whether the user is logged in, but also whether they are the admin, before it displays the page content
// You can implement all the admin tools functionality from this script, or...

// execute the header script:
require_once "header.php";

echo "<b> Here are the details of user: " . $_GET['username'] . "</b> <br><br>";

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

		$query = "SELECT * FROM users WHERE username = '{$_GET['username']}'";

		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);

		 // how many rows of data come back?
        $n = mysqli_num_rows($result);

		if ($n > 0)
		{
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
			echo "<tr><th>First Name</th> <th> Last Name </th> <th> Username </th> <th> Password </th> <th> Email </th> <th> Date of Birth </th> <th> Telephone </th> </tr>";

		// loop over all rows, adding them into the table:
            for ($i=0; $i<$n; $i++)
            {
                // fetch one row as an associative array (elements named after columns):
                $row = mysqli_fetch_assoc($result);
                // add it as a row in our table:
                echo "<tr>";
                echo "<td>{$row['firstName']}</td> <td>{$row['lastName']}</td> <td> {$row['username']}</td> <td>{$row['password']}</td> <td>{$row['email']}</td> <td>{$row['dob']}</td> <td>{$row['telephone']}</td>";
                echo "</tr>";
            }
            echo "</table>";
		}
		else
        {
            // no users found...:
            echo " <br> no users found<br>";
        }

				//surveys of the user
				$query = "SELECT * FROM surveys WHERE usernameCreated = '{$_GET['username']}'";

				// this query can return data ($result is an identifier):
				$result = mysqli_query($connection, $query);

				 // how many rows of data come back?
						$n = mysqli_num_rows($result);

				if ($n > 0)
				{
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
						echo "<tr><th>Survey Name</th> <th> Number of Questions </th> </tr>";
						// loop over all rows, adding them into the table:
									for ($i=0; $i<$n; $i++)
									{
											// fetch one row as an associative array (elements named after columns):
											$row = mysqli_fetch_assoc($result);
											// add it as a row in our table:
											echo "<tr>";
											echo "<td>{$row['surveyName']}</td> <td>{$row['numQuestions']}</td>";
											echo "</tr>";
									}
									echo "</table>";
						}
						else
								{
										// no users found...:
										echo " <br> no surveys found<br>";
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
