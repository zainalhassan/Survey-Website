<?php
require_once "header.php";

$username = $_SESSION['username'];
$numberOfQuestions = 0;
// connect directly to our database (notice 4th argument):
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// if the connection fails, we need to know, so allow this exit:
if (!$connection)
{
  die("Connection failed: " . $mysqli_connect_error);
}

$query = "SELECT * FROM questions WHERE surveyName = '{$_GET['surveyName']}'";

// this query can return data ($result is an identifier):
$result = mysqli_query($connection, $query);

 // how many rows of data come back?
$n = mysqli_num_rows($result);
echo "<h2> This is your survey:  {$_GET['surveyName']} </h2>";

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
    echo "<tr> <th>Question  Number </th> <th>Question Type</th> <th>Question</th> <th> Question Options </tr>";
    // loop over all rows, adding them into the table:
          for ($i=0; $i<$n; $i++)
          {
              // fetch one row as an associative array (elements named after columns):
              $row = mysqli_fetch_assoc($result);
              // add it as a row in our table:
              echo "<tr>";
              echo "<td>{$row['questionNumber']}</td> <td>{$row['questionType']}</td> <td>{$row['question']} <td> {$row['questionOptions']} </td>";
              echo "</tr>";
          }
          echo "</table>";
    }
    else
        {
            // no questions created for this survey...
            echo " <br> no questions found<br>";
        }

        $query = "SELECT * FROM questions WHERE surveyName = '{$_GET['surveyName']}'";

        // this query can return data ($result is an identifier):
        $result1 = mysqli_query($connection, $query);

        // how many rows of data come back?
        $numOfQuestions = mysqli_num_rows($result1);

        if ($numOfQuestions > 0)
        {
          echo "<form action = 'surveys_view.php?surveyName={$_GET['surveyName']}' method = 'POST'>";
          for ($i=0; $i<$numOfQuestions; $i++)
          {
            // fetch one row as an associative array (elements named after columns):
            $row = mysqli_fetch_assoc($result1);
            echo <<<_END
            <h3> question number : {$row['questionNumber']}  </h3>

              <label> {$row['question']} </label> <br>
_END;
              if($row['questionType'] == 'text')
              {
                echo "<input type = '{$row['questionType']}' name = '{$row['questionID']}'  minlength = '1' maxlength = '255'>";
              }
              elseif($row['questionType'] == 'number')
              {
                echo "<input type = '{$row['questionType']}' name = '{$row['questionID']}'  min = '0'>";
              }
              elseif($row['questionType'] == 'date')
              {
                echo "<input type = '{$row['questionType']}' name = '{$row['questionID']}' >";
              }
              elseif($row['questionType'] == 'radio')
              {
                $questionOptions = explode (',', $row['questionOptions']);
                for($j=0; $j<sizeof($questionOptions); $j++)
                {
                  echo "<input type = '{$row['questionType']}' name = '{$row['questionID']}' value = '$questionOptions[$j]'> {$questionOptions[$j]}";
                  echo "<br>";
                }
              }
          }
          echo <<<_END
            <button name = "submitAnswersButton" type = "submit" value = "submitAnswers"> Submit answers </button>
          </form>
_END;
if(isset($_POST['submitAnswersButton']))
{
  $query = "SELECT * FROM questions WHERE surveyName = '{$_GET['surveyName']}'";

  $result = mysqli_query($connection, $query);
  $numOfQuestions = mysqli_num_rows($result);
  if ($numOfQuestions > 0)
  {
    for ($i=0; $i<$numOfQuestions; $i++)
    {
      $rows = mysqli_fetch_assoc($result);

      $questionID =  $rows['questionID'];
      echo $questionIDPost = $_POST[$questionID];

      //delete old answers of a survey
      $sqlDelete = "DELETE FROM answers WHERE questionID = '{$rows['questionID']}' AND usernameAnswered = '$username' AND surveyName = '{$_GET['surveyName']}';";

      $resultsqlDelete = mysqli_query($connection, $sqlDelete);

      if ($resultsqlDelete)
      {
        echo "Previous answer for question " . $rows['questionNumber']  . " deleted <br>";
      }
      else
      {
        echo "Previous answer for question " . $rows['questionNumber']  . " not deleted <br>". mysqli_error($connection);
      }

      echo $sqlInsert = "INSERT INTO answers (questionID, answer, usernameAnswered, surveyName) VALUES ('{$rows['questionID']}', '$questionIDPost', '$username', '{$_GET['surveyName']}');";
      $resultsqlInsert = mysqli_query($connection, $sqlInsert);

      if ($resultsqlInsert)
      {
        echo "Answer for question " . $rows['questionNumber']  . " inserted <br>";
      }
      else
      {
        echo "Answer for question " . $rows['questionNumber']  . " not inserted <br>". mysqli_error($connection);
      }
    }
  }
    header("Location: answers_view.php?surveyName={$_GET['surveyName']}");
  }
}
// finish off the HTML for this page:
require_once "footer.php";
?>
