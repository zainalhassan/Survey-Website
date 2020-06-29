<?php

require_once "header.php";
// $questionNumber = $_POST['questionNumber'];
// $questionType = $_POST['questionType'];

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

	$query = "SELECT numQuestions FROM surveys WHERE surveyName = '{$_GET['surveyName']}'";

	$result = mysqli_query($connection, $query);

	// how many rows of data come back?
	$n = mysqli_num_rows($result);

	if ($n > 0)
	{
		$row = mysqli_fetch_assoc($result);
	}

		echo "<form action = 'questions_insert.php?surveyName={$_GET['surveyName']}' method = 'POST'>";
		echo "survey is called <b> {$_GET['surveyName']} </b>";
		echo "<br>";

		echo "<label> input question number: </label>";

		//show them one extra question if they wish to add a new question to the survey
		$dropDownNumQs = 1;
		$dropDownNumQsMax = $row['numQuestions'] + 1;

		echo "<select name = 'choosequestionNumber' required>";
		while($dropDownNumQs <= $dropDownNumQsMax)
		{
			echo "<option value='$dropDownNumQs'>$dropDownNumQs</option>";
			//add 1 through every loop to get all options
			$dropDownNumQs++;
		}

		echo "</select>";

		echo "<label> input question type: </label>";
		echo "<select name = 'questionTypeList' required>";
			echo "<option value = 'text'> text </option>";
			echo "<option value = 'number'> number </option>";
			echo "<option value = 'date'> date </option>";
			echo "<option value = 'radio'> radio </option>";
		echo "</select>";

		echo "<label> input question: </label>";
		echo "<input type = 'text' name = 'question'required>";
		echo "<label> if radio, please enter each option followed by a comma: </label>";
		echo "<input type = 'text' name = 'questionOptions'>";
		echo "<button name = 'submitQuestionButton' type = 'submit'> Submit question </button>";

		echo "</form>";

	if(isset($_POST['submitQuestionButton']))
	{
		//if already chosen that question number, show message saying choose different number
		$query = "SELECT * FROM questions WHERE questionNumber = '{$_POST['choosequestionNumber']}' AND surveyName = '{$_GET['surveyName']}'";
		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);

		// how many rows of data come back?
		$n = mysqli_num_rows($result);

		if ($n == 0)
		{
			echo "<br>";
			//question inserton
			$query = "INSERT INTO questions (questionNumber, surveyName, questionType, question, questionOptions) VALUES ('{$_POST['choosequestionNumber']}', '{$_GET['surveyName']}', '{$_POST['questionTypeList']}', '{$_POST['question']}', '{$_POST['questionOptions']}')";
			// this query can return data ($result is an identifier):
			$result = mysqli_query($connection, $query);

			// no data returned, we just test for true(success)/false(failure):
			if ($result)
			{
				echo "<form action = 'questions_insert.php?surveyName={$_GET['surveyName']}' method = 'POST'>";
					echo "<button name = 'refreshPageButton' type = 'submit'> Question submitted, click to add another </button>";
				echo "</form>";
			}
			else
			{
				echo "question not submitted";
			}
			//changing survey number of questions when a question is added
			$query = "UPDATE surveys SET numQuestions = (SELECT COUNT(QuestionID) FROM questions WHERE surveyName= '{$_GET['surveyName']}') WHERE surveyName = '{$_GET['surveyName']}'";
			// this query can return data ($result is an identifier):
			$result = mysqli_query($connection, $query);

			// no data returned, we just test for true(success)/false(failure):
			if ($result)
			{
				echo "surveys table updated";
			}
			else
			{
				echo "surveys table not updated";
			}
		}
		else
		{
			echo "Question with same question number already created, please choose a different question number";
		}
	}
}
require_once "footer.php";
?>
