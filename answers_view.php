<?php
require_once "header.php";

$username = $_SESSION['username'];

if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}
else
{
// connect directly to our database (notice 4th argument):
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// if the connection fails, we need to know, so allow this exit:
if (!$connection)
{
  die("Connection failed: " . $mysqli_connect_error);
}
  //shows the answers table with the survey name from the questions table(a FK in questions table)
  $sql = "SELECT * FROM answers WHERE surveyName = '{$_GET['surveyName']}' AND usernameAnswered = '$username'";
  // this query can return data ($result is an identifier):
  $outcome = mysqli_query($connection, $sql);

   // how many rows of data come back?
  $n = mysqli_num_rows($outcome);
  echo "<h2> These are your answers to survey:  {$_GET['surveyName']} </h2>";

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
      echo "<tr> <th>Question ID </th> <th>Answer</th><tr>";
      // loop over all rows, adding them into the table:
      for ($i=0; $i<$n; $i++)
      {
        // fetch one row as an associative array (elements named after columns):
        $rows = mysqli_fetch_assoc($outcome);
        // add it as a row in our table:
        echo "<tr>";
        echo "<td>{$rows['questionID']}</td> <td>{$rows['answer']} </td>";
        echo "</tr>";
      }
        echo "</table>";
  }
  else
  {
    // no questions created...
    echo " <br> no answers found<br>";
  }

  $query = "SELECT questionID, questionNumber, surveyName, questionType, question, questionOptions FROM questions WHERE surveyName = '{$_GET['surveyName']}'";

  // this query can return data ($result is an identifier):
  $result = mysqli_query($connection, $query);

  $resultSql = mysqli_query($connection, $sql);

  // calculates the number of questions within the survey
  $numOfQuestions = mysqli_num_rows($result);

  //all of this is coming from the query done for the table
  $m = mysqli_num_rows($resultSql);

  if ($numOfQuestions > 0)
  {
    echo "<form action = 'answers_view.php?surveyName={$_GET['surveyName']}' method = 'POST'>";
    for ($i=0; $i<$numOfQuestions; $i++)
    {
      // fetch one row as an associative array (elements named after columns):
      $row = mysqli_fetch_assoc($result);
      $rows = mysqli_fetch_assoc($resultSql);
      echo <<<_END
      <h3> question number : {$row['questionNumber']}</h3>

      <label> {$row['question']} </label> <br>
_END;

      // cycle through the input types and insert validation on them
      if($row['questionType'] == 'text')
      {
        echo "<input type = '{$row['questionType']}' name = '{$rows['answerID']}' value = '{$rows['answer']}' minlength = '1' maxlength = '255'>";
      }
      elseif($row['questionType'] == 'number')
      {
        echo "<input type = '{$row['questionType']}' name = '{$rows['answerID']}' value = '{$rows['answer']}' min = '0'>";
      }
      elseif($row['questionType'] == 'date')
      {
        echo "<input type = '{$row['questionType']}' name = '{$rows['answerID']}' value = '{$rows['answer']}'>";
      }
      elseif($row['questionType'] == 'radio')
      {
        $questionOptions = explode (',', $row['questionOptions']);
        for($j=0; $j < sizeof($questionOptions); $j++)
        {
          if ($questionOptions[$j] == $rows['answer'])
          {
            echo "<input type = '{$row['questionType']}' name = '{$rows['answerID']}' value = '$questionOptions[$j]' checked> {$questionOptions[$j]}";
          }
          else
          {
            echo "<input type = '{$row['questionType']}' name = '{$rows['answerID']}' value = '$questionOptions[$j]'> {$questionOptions[$j]}";
          }
            echo "<br>";
        }
      }
    }

    echo <<<_END
    <button name = "updateAnswersButton" type = "submit" value = "updateAnswers"> Update answers </button>
    </form>
_END;
    //if update button pressed, get all info of answers first, then update answers.
    if(isset($_POST['updateAnswersButton']))
    {
      $query = "SELECT answerID,answers.questionID,answer, usernameAnswered,answers.surveyName,questionNumber FROM answers INNER JOIN questions USING (questionID) WHERE answers.surveyName = '{$_GET['surveyName']}'";
      echo "<br>";
      $result = mysqli_query($connection, $query);
      $n = mysqli_num_rows($result);

      if ($n > 0)
      {
        for ($i=0; $i<$numOfQuestions; $i++)
        {
          // fetch one row as an associative array (elements named after columns):
          $row = mysqli_fetch_assoc($result);

          //posts the vakue of the input type
          $answerIDTest =  $row['answerID'];
          $answerTest = $_POST[$answerIDTest];

          $sqlUpdate = "UPDATE answers SET answer = '$answerTest' WHERE questionID = {$row['questionID']} AND usernameAnswered = '$username'";
          echo $sqlUpdate;
          echo "<br>";

          $resultsqlUpdate = mysqli_query($connection, $sqlUpdate);

          //display message if inserted or not
          if ($resultsqlUpdate)
          {
            echo "<br> answer for question " . $row['questionNumber']  . " updated <br>";
          }
          else
          {
            echo "<br> answer for question " . $row['questionNumber']  . " not updated <br>". mysqli_error($connection);
          }
        }
      }
    }
  }
}
// finish off the HTML for this page:
require_once "footer.php";
?>
