<?php

// Things to notice:
// This is the page where each user can MANAGE their surveys
// As a suggestion, you may wish to consider using this page to LIST the surveys they have created
// Listing the available surveys for each user will probably involve accessing the contents of another TABLE in your database
// Give users options such as to CREATE a new survey, EDIT a survey, ANALYSE a survey, or DELETE a survey, might be a nice idea
// You will probably want to make some additional PHP scripts that let your users CREATE and EDIT surveys and the questions they contain
// REMEMBER: Your admin will want a slightly different view of this page so they can MANAGE all of the users' surveys

// execute the header script:
require_once "header.php";

// default values we show in the form:
$insertSurveyName = "";
$insertSurveyNumQuestions = "";
// strings to hold any validation error messages:
$insertSurveyName_val = "";
$insertSurveyNumQuestions_val = "";
$errors = "";

$user = $_SESSION['username'];

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

	//welcome message
	echo "hello $user";
	echo "<br>";
	echo "Here are your surveys, you can view the sureveys you have created as well as create and modify new surveys <br>";
	echo "<br>";

	//buttons used to display different survey functions
	echo <<<_END
	<form action="surveys_manage.php" method="POST">
		<button name = "createSurveyButton" type = "submit"  value = "createSurvey"> Create new survey </button>
		<button name = "viewSurveyButton" type="submit" value="viewSurvey">view surveys</button>
		<button name = "templateSurveysButton" type = "submit"> view template surveys </button>
	</form>
	<form action = "samplePoll.php" method = "POST">
		<button name = type = "submit"> view Sample Poll </button>
	</form>
	<form action = "samplePollResults.php" method = "POST">
		<button name = type = "submit"> view Sample Poll Results </button>
	</form>
_END;

	//if view survey button pressed show them surveys and their functions
	if(isset($_POST['viewSurveyButton']))
	{
		$query = "SELECT * FROM surveys WHERE usernameCreated != 'admin'";

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
		echo "<tr><th>Survey Name</th> <th> Number of Questions </th> <th> Delete a survey </th> <th> Edit a survey </th> <th> Add questions </th> <th> View answers </th> </tr>";
		// loop over all rows, adding them into the table:
		for ($i=0; $i<$n; $i++)
		{
			// fetch one row as an associative array (elements named after columns):
			$row = mysqli_fetch_assoc($result);
			// add it as a row in our table:
			echo "<tr>";
			echo "<td> <a href='surveys_view.php?surveyName={$row['surveyName']}' '>" . "{$row['surveyName']}" . "</a> </td> <td>{$row['numQuestions']}</td>";
			echo "<td> <form action = 'surveys_manage.php' method = 'POST'> <button name = 'deleteSurveyButton' type = 'submit' value = '{$row['surveyName']}'> Delete </button> </form> </td>";
			echo "<td> <form action = 'surveys_edit.php?surveyName={$row['surveyName']}&surveyNumQuestions={$row['numQuestions']}' method = 'POST'> <button name = 'editSurveyButton' type = 'submit'> Edit </button> </form> </td>";
			echo "<td> <form action = 'questions_insert.php?surveyName={$row['surveyName']}' method = 'POST'> <button name = 'addQuestionsButton' type = 'submit'> Add questions </button> </form> </td>";
			echo "<td> <form action = 'answers_view.php?surveyName={$row['surveyName']}' method = 'POST'> <button name = 'viewAnswersButton' type = 'submit'> View your answers </button> </form> </td>";
			echo "</tr>";
		}
			echo "</table>";
	}
	else
	{
			// no surveys created...
			echo " <br> no surveys found<br>";
	}
	echo "click on the survey name to complete the survey <br>";
}

		if(isset($_POST['templateSurveysButton']))
		{
			$query = "SELECT * FROM surveys WHERE usernameCreated = 'admin'";

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
					echo "<tr><th>Survey Name</th> <th> Number of Questions </th> <th> Created By </th> <th> View answers </th> </tr>";
					// loop over all rows, adding them into the table:
								for ($i=0; $i<$n; $i++)
								{
										// fetch one row as an associative array (elements named after columns):
										$row = mysqli_fetch_assoc($result);
										// add it as a row in our table:
										echo "<tr>";
										echo "<td> <a href='surveys_view.php?surveyName={$row['surveyName']}' '>" . "{$row['surveyName']}" . "</a>";
										echo "<td>{$row['numQuestions']}</td> <td> {$row['usernameCreated']} </td>";
										echo "<td> <form action = 'answers_view.php?surveyName={$row['surveyName']}' method = 'POST'> <button name = 'viewAnswersButton' type = 'submit'> View your answers </button> </form> </td>";
										echo "</tr>";
								}
								echo "</table>";
					}
					else
							{
									// no surveys found...:
									echo " <br> no surveys found<br>";
							}
		}
		if (isset($_POST['deleteSurveyButton']))
		{
			$query = "DELETE FROM surveys WHERE surveyName = '{$_POST['deleteSurveyButton']}'";

			$result = mysqli_query($connection, $query);
			if($result)
			{
				//reloads the page automatically
				//header ("Location: " . $_SERVER['PHP_SELF']);
				echo "<br>";
				echo "Survey deleted";
				echo "<br>";

			}
			else
			{
				echo "Survey not deleted";
			}

		}

		if(isset($_POST['createSurveyButton']))
		{
				echo <<<_END
				<form method = "POST">
					<label> What is the name of new survey: </label> <br>
					<input type = "text" name = "surveyName" minlength = "1" maxlength="30" value="$insertSurveyName" required> $insertSurveyName_val
					<br>
					<label> How many questions would you like: </label> <br>
					<input type = "number" name = "surveyNumQuestions" min = "0" max="100" value="$insertSurveyNumQuestions" required> $insertSurveyNumQuestions_val

					<button name="submitSurvey" type="submit" value="submitSurvey">Submit new survey</button>
				</form>
_END;
}
				if(isset($_POST['submitSurvey']))
				{
					if($errors == "")
					{
						$query = "INSERT INTO surveys (surveyName, numQuestions, usernameCreated) VALUES ('{$_POST['surveyName']}', '{$_POST['surveyNumQuestions']}', '$user');";

						$result = mysqli_query($connection, $query);

						if($result)
						{
							//reloads the page automatically
							//header ("Location: " . $_SERVER['PHP_SELF']);
							echo "<br>";
							echo "Survey created";

							$query = "SELECT * FROM surveys WHERE surveyName = '{$_POST['surveyName']}'";

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
								echo "<tr><th>Survey Name</th> <th> Number of Questions </th> <th> Add Question data</th></tr>";
								// loop over all rows, adding them into the table:
					      for ($i=0; $i<$n; $i++)
					     	{
					     		// fetch one row as an associative array (elements named after columns):
					       $row = mysqli_fetch_assoc($result);
					      	// add it as a row in our table:
					      	echo "<tr>";
									echo "<td>{$row['surveyName']}</td> <td>{$row['numQuestions']}</td> <td> <form action = 'questions_insert.php?surveyName={$row['surveyName']}' method = 'POST'> <button name = 'addQuestionsButton' type = 'submit'> Add question data </button> </form> </td>";
									echo "</tr>";
						    }
					      echo "</table>";
							}
							else
					        {
					            // no surveys found...:
					            echo " <br> no surveys found<br>";
					        }

							// we're finished with the database, close the connection:
					    mysqli_close($connection);
							echo "<br>";
						}
						else
						{
							echo "Survey not created";
						}
					}
					else
						{
							echo "survey creation failed, please check the errors shown above and try again<br>";
						}
				}

				if(isset($_POST['addQsButton']))
				{
					echo $surveyNameQs;
						$query = "INSERT INTO questions (questionNumber, surveyName, questionType, question) VALUES ('{$_POST['questionNumber']}', '{$_POST['surveyName']}', '{$_POST['questionType']}', '{$_POST['question']}')";
						echo $query;
						// this query can return data ($result is an identifier):
						$result = mysqli_query($connection, $query);

					 	// how many rows of data come back?
						$n = mysqli_num_rows($result);

						if ($n > 0)
						{
							echo "questions submitted";
						}
						else
						{
							echo "questions not submitted";
						}
				}

				if(isset($_POST['submitQuestionsTest']))
				{
					echo "yu pressed submit questions" . $numberOfQuestions . "ths ijbijk";
					echo $_POST['typeOfQuestion'];
				}
}

// finish off the HTML for this page:
require_once "footer.php";
?>
