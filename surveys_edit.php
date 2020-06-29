<?php

require_once "header.php";

//grabs old survey name before new one replaces it, to be used in the query
 $oldsurveyName =  $_GET['surveyName'];
 $message = "";

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
  // set old survey name to new one
	if(isset($_POST['existingSurveyName']))
	{
		$_GET['surveyName'] = $_POST['existingSurveyName'];
		echo $_POST['existingSurveyName'];
	}
  //set old survey number of questions to new one
	if(isset($_POST['existingSurveyNumQuestions']))
	{
		$_GET['surveyNumQuestions'] = $_POST['existingSurveyNumQuestions'];
		echo $_POST['existingSurveyNumQuestions'];
	}

  //form + button to display the survey name, number of questions and button
  echo <<<_END
  <form action = "surveys_edit.php?surveyName={$_GET['surveyName']}&surveyNumQuestions={$_GET['surveyNumQuestions']}" method = "POST">
    <label> Existing Survey name </label>
    <input type "text" name = "existingSurveyName" value = "{$_GET['surveyName']}">
    <br>
    <label> Existing number of questions </label>
    <input type "text" name = "existingSurveyNumQuestions" value = "{$_GET['surveyNumQuestions']}">
    <button name = "submitsurveyEditButton" type = "submit" value = "submitsurveyEdit"> Submit changes </button>
  <form>
_END;

  //if submit button is pressed, execute query to update survey name and survey number of questions
  if(isset($_POST['submitsurveyEditButton']))
  {
    $query = "UPDATE surveys SET surveyName = '{$_POST['existingSurveyName']}', numQuestions = '{$_POST['existingSurveyNumQuestions']}' WHERE surveyName = '$oldsurveyName'";
    $result = mysqli_query($connection, $query);

    if ($result)
    {
      $message = "survey updated";
    }
    else
    {
      $message = "survey not updated";
    }
  }
echo $message;
}
require_once "footer.php";
?>
