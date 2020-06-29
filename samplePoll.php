<?php
require_once "header.php";

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
elseif ($_SESSION['username'])
{
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}

  echo "<h3> Sample Poll : Favourite Sports</h3>";
	//query for gathering data for the table
  $query = "SELECT * FROM samplePoll;";

  $result = mysqli_query($connection, $query);
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
		echo "<tr> <th> Option </th> <th> Number of votes </th> <th> Click to vote </th> <th> Voted By </th> </tr>";

		echo "<form action = 'samplePoll.php' method = 'POST'>";

  	// loop over all rows, adding them into the table:
		for ($i=0; $i<$n; $i++)
		{
			// fetch one row as an associative array (elements named after columns):
			$row = mysqli_fetch_assoc($result);
			// add it as a row in our table:
			echo "<tr>";
			echo "<td>{$row['option']}</td>  <td>{$row['votes']}</td> <td>  <button name = 'voteButton' type = 'submit' value = '{$row['samplePollID']}'> Vote </button> </td> <td> <a href='userDetails.php?username={$row['usernameVoted']}' '>" . "{$row['usernameVoted']}" . "</a> </td>";
			echo "</tr>";
		}
			echo "</table>";
	}
	else
	{
			// no sample polls found...:
			echo " <br> no sample polls found found<br>";
	}
  		echo "</form>";

			//if button pressed, update the vote count by making vote = vote +1
      if(isset($_POST['voteButton']))
      {
        $sql = "UPDATE samplePoll SET votes = votes + 1 WHERE samplePollID = '{$_POST['voteButton']}'";
        $resultUpdateVote = mysqli_query($connection, $sql);
        if($resultUpdateVote)
        {
          echo "Thank you for your Vote.";
        }
        else
        {
          echo "Vote not submitted.";
        }
				//refrehes page automatically
        header("Location: samplePoll.php");
      }
}
require_once "footer.php";
?>
