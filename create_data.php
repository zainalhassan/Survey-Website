<?php

// read in the details of our MySQL server:
require_once "credentials.php";

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
	die("Connection failed: " . $mysqli_connect_error);
}

// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Database created successfully, or already exists<br>";
}
else
{
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);

///////////////////////////////////////////
////////////// DROP TABLES ////////////////
///////////////////////////////////////////
// if there's an old version of questions table, then drop it:
$sql = "DROP TABLE IF EXISTS samplePoll";
// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: samplePoll<br>";
}
else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}
// if there's an old version of questions table, then drop it:
$sql = "DROP TABLE IF EXISTS answers";
// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: answers<br>";
}
else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

// if there's an old version of questions table, then drop it:
$sql = "DROP TABLE IF EXISTS questions";
// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: questions<br>";
}
else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

// if there's an old version of surveys table, then drop it:
$sql = "DROP TABLE IF EXISTS surveys";
// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: surveys<br>";
}
else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

// if there's an old version of users table, then drop it:
$sql = "DROP TABLE IF EXISTS users";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Dropped existing table: users<br>";
}
else
{
	die("Error checking for existing table: " . mysqli_error($connection));
}

///////////////////////////////////////////
////////////// CREATE TABLES //////////////
///////////////////////////////////////////

// make the users table:
$sql = "CREATE TABLE users (firstName VARCHAR(20), lastName VARCHAR(30), username VARCHAR(16), password VARCHAR(16), email VARCHAR(64), dob DATE, telephone VARCHAR(16), PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: users<br>";
}
else
{
	die("Error creating table: " . mysqli_error($connection));
}

// make the surveys table:
$sql = "CREATE TABLE surveys (surveyName VARCHAR(30), numQuestions INT(3), usernameCreated VARCHAR (30), PRIMARY KEY(surveyName), FOREIGN KEY (usernameCreated) REFERENCES users(username) ON UPDATE CASCADE ON DELETE SET NULL)";
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: surveys <br>";
}
else
{
	die("Error creating table: " . mysqli_error($connection));
}

//make the questions table with surveyName as FK from surveys table
$sql = "CREATE TABLE questions (questionID INT(3) AUTO_INCREMENT, questionNumber INT(3), surveyName VARCHAR(30), questionType VARCHAR(20), question VARCHAR(500), questionOptions VARCHAR (500), PRIMARY KEY(questionID), FOREIGN KEY (surveyName) REFERENCES surveys(surveyName) ON UPDATE CASCADE ON DELETE SET NULL)";
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: questions <br>";
}
else
{
	die("Error creating table: " . mysqli_error($connection));
}

//make the answers table with QuestionID as FK from questions table
$sql = "CREATE TABLE answers (answerID INT(3) AUTO_INCREMENT, questionID INT(3), answer VARCHAR(500), usernameAnswered VARCHAR (30), surveyName VARCHAR(30), PRIMARY KEY(answerID), FOREIGN KEY (questionID) REFERENCES questions(questionID) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (usernameAnswered) REFERENCES users (username) ON UPDATE CASCADE ON DELETE SET NULL, FOREIGN KEY (surveyName) REFERENCES surveys (surveyName) ON UPDATE CASCADE ON DELETE SET NULL)";
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: answers <br>";
}
else
{
	die("Error creating table: " . mysqli_error($connection));
}
//make the questions table with surveyName as FK from surveys table
$sql = "CREATE TABLE samplePoll (samplePollID INT (3) AUTO_INCREMENT, name VARCHAR (30), option VARCHAR (100), votes INT UNSIGNED default 0, usernameVoted VARCHAR (16), PRIMARY KEY (samplePollID), FOREIGN KEY (usernameVoted) REFERENCES users (username)ON UPDATE CASCADE ON DELETE SET NULL)";
if (mysqli_query($connection, $sql))
{
	echo "Table created successfully: samplePoll <br>";
}
else
{
	die("Error creating table: " . mysqli_error($connection));
}
///////////////////////////////////////////
///////////// POPULATE TABLES /////////////
///////////////////////////////////////////

// put some data into users table:
$firstNames[] = 'Billy'; $lastNames[] = 'Texas'; $usernames[] = 'admin'; $passwords[] = 'secret'; $emails[] = 'admin@gmail.com'; $dobs[] = '1984-02-09'; $telephones[] = '076865465667';
$firstNames[] = 'Barry'; $lastNames[] = 'Maynard'; $usernames[] = 'barrym'; $passwords[] = 'letmein'; $emails[] = 'barry@m-domain.com'; $dobs[] = '1984-11-09'; $telephones[] = '01267875863';
$firstNames[] = 'Mandy'; $lastNames[] = 'Bell'; $usernames[] = 'mandyb'; $passwords[] = 'abc123'; $emails[] = 'webmaster@mandy-g.co.uk'; $dobs[] = '1998-11-19'; $telephones[] = '08686839273';
$firstNames[] = 'Timmy'; $lastNames[] = 'White'; $usernames[] = 'timmy'; $passwords[] = 'secret95'; $emails[] = 'timmy@lassie.com'; $dobs[] = '2000-03-20'; $telephones[] = '07897866543';
$firstNames[] = 'Brian'; $lastNames[] = 'Gordon'; $usernames[] = 'briang'; $passwords[] = 'password'; $emails[] = 'brian@quahog.gov'; $dobs[] = '2001-03-20'; $telephones[] = '01614567839';
$firstNames[] = 'a'; $lastNames[] = 'aa'; $usernames[] = 'a'; $passwords[] = 'test'; $emails[] = 'a@alphabet.test.com'; $dobs[] = '2004-03-20'; $telephones[] = '07899898654';
$firstNames[] = 'b'; $lastNames[] = 'bb'; $usernames[] = 'b'; $passwords[] = 'test'; $emails[] = 'b@alphabet.test.com'; $dobs[] = '1980-04-12'; $telephones[] = '07162353828';
$firstNames[] = 'c'; $lastNames[] = 'cc';$usernames[] = 'c'; $passwords[] = 'test'; $emails[] = 'c@alphabet.test.com'; $dobs[] = '1960-03-20'; $telephones[] = '07863534632';
$firstNames[] = 'd'; $lastNames[] = 'dd';$usernames[] = 'd'; $passwords[] = 'test'; $emails[] = 'd@alphabet.test.com'; $dobs[] = '2001-01-01'; $telephones[] = '07898887736';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	$sql = "INSERT INTO users (firstName, lastName, username, password, email, dob, telephone) VALUES ('$firstNames[$i]', '$lastNames[$i]', '$usernames[$i]', '$passwords[$i]', '$emails[$i]', '$dobs[$i]', '$telephones[$i]')";

	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}
	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}
// put some data into surveys table
$surveyNames [] = 'Food'; $numQuestions [] = '5'; $usernamesCreated [] = 'admin';
$surveyNames [] = 'Sports'; $numQuestions [] = '5'; $usernamesCreated [] = 'admin';
$surveyNames [] = 'Music'; $numQuestions [] = '5'; $usernamesCreated [] = 'admin';

$surveyNames [] = 'Cars'; $numQuestions [] = '3'; $usernamesCreated [] = 'barrym';
$surveyNames [] = 'Movies'; $numQuestions [] = '4'; $usernamesCreated [] = 'timmy';
$surveyNames [] = 'Bikes'; $numQuestions [] = '5'; $usernamesCreated [] = 'mandyb';
$surveyNames [] = 'TV'; $numQuestions [] = '1'; $usernamesCreated [] = 'barrym';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($surveyNames); $i++)
{
	$sql = "INSERT INTO surveys (surveyName, numQuestions, usernameCreated ) VALUES ('$surveyNames[$i]', '$numQuestions[$i]', '$usernamesCreated[$i]')";

	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}
	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

// put some data into questions table
$questionNumbers [] = '1'; $questionSurveyNames [] = 'Food'; $questionTypes [] = 'number'; $questions [] = 'How many meals do you have a day?'; $questionOptions [] = '';
$questionNumbers [] = '2'; $questionSurveyNames [] = 'Food'; $questionTypes [] = 'text'; $questions [] = 'What is your favourite food?'; $questionOptions [] = '';
$questionNumbers [] = '3'; $questionSurveyNames [] = 'Food'; $questionTypes [] = 'text'; $questions [] = 'What is the strangest food you have had?'; $questionOptions [] = '';
$questionNumbers [] = '4'; $questionSurveyNames [] = 'Food'; $questionTypes [] = 'radio'; $questions [] = 'Sweet or sour?'; $questionOptions [] = 'Sweet,Sour';
$questionNumbers [] = '5'; $questionSurveyNames [] = 'Food'; $questionTypes [] = 'text'; $questions [] = 'Which food do you hate the the most?'; $questionOptions [] = '';

$questionNumbers [] = '1'; $questionSurveyNames [] = 'Sports'; $questionTypes [] = 'text'; $questions [] = 'Do you play sports?'; $questionOptions [] = '';
$questionNumbers [] = '2'; $questionSurveyNames [] = 'Sports'; $questionTypes [] = 'text'; $questions [] = 'Do you watch sports?'; $questionOptions [] = '';
$questionNumbers [] = '3'; $questionSurveyNames [] = 'Sports'; $questionTypes [] = 'radio'; $questions [] = 'Which sports do you play?'; $questionOptions [] = 'Football,Basketball,Cricket,Tennis,Badminton,Other';
$questionNumbers [] = '4'; $questionSurveyNames [] = 'Sports'; $questionTypes [] = 'number'; $questions [] = 'How many hours of sports do you play a week?'; $questionOptions [] = '';
$questionNumbers [] = '5'; $questionSurveyNames [] = 'Sports'; $questionTypes [] = 'text'; $questions [] = 'What is the reason you like/dislike sports?'; $questionOptions [] = '';

$questionNumbers [] = '1'; $questionSurveyNames [] = 'Music'; $questionTypes [] = 'radio'; $questions [] = 'Do you listen to music?'; $questionOptions [] = 'Yes,No';
$questionNumbers [] = '2'; $questionSurveyNames [] = 'Music'; $questionTypes [] = 'radio'; $questions [] = 'What type of music do you listen to?'; $questionOptions [] = 'Rap,R&B,Hip-Hop,Pop,Reggae,Other';
$questionNumbers [] = '3'; $questionSurveyNames [] = 'Music'; $questionTypes [] = 'text'; $questions [] = 'Who is your favourite artist?'; $questionOptions [] = '';
$questionNumbers [] = '4'; $questionSurveyNames [] = 'Music'; $questionTypes [] = 'text'; $questions [] = 'Do you listen to music in different languages?'; $questionOptions [] = '';
$questionNumbers [] = '5'; $questionSurveyNames [] = 'Music'; $questionTypes [] = 'text'; $questions [] = 'If you do, why do you listen to music?'; $questionOptions [] = '';

$questionNumbers [] = '1'; $questionSurveyNames [] = 'Movies'; $questionTypes [] = 'radio'; $questions [] = 'Do you watch movies?'; $questionOptions [] = 'Yes,No';
$questionNumbers [] = '2'; $questionSurveyNames [] = 'Movies'; $questionTypes [] = 'radio'; $questions [] = 'What type of movies do you watch?'; $questionOptions [] = 'Acton,Comedy,Horror,Romance,Sci-Fi,Animation,Other';
$questionNumbers [] = '3'; $questionSurveyNames [] = 'Movies'; $questionTypes [] = 'radio'; $questions [] = 'How many movies do you watch a month?'; $questionOptions [] = 'None, 1-3, 4-6, 7-9,10 or more';
$questionNumbers [] = '4'; $questionSurveyNames [] = 'Movies'; $questionTypes [] = 'text'; $questions [] = 'Which movie do you recommend most to your friends?'; $questionOptions [] = '';

$questionNumbers [] = '1'; $questionSurveyNames [] = 'Bikes'; $questionTypes [] = 'radio'; $questions [] = 'Do you own a bike?'; $questionOptions [] = 'Yes,No';
$questionNumbers [] = '2'; $questionSurveyNames [] = 'Bikes'; $questionTypes [] = 'radio'; $questions [] = 'Are bikes a good purchase?'; $questionOptions [] = 'Agree, Neutral, Disagree';
$questionNumbers [] = '3'; $questionSurveyNames [] = 'Bikes'; $questionTypes [] = 'text'; $questions [] = 'What is your reason behind the previous question?'; $questionOptions [] = '';
$questionNumbers [] = '4'; $questionSurveyNames [] = 'Bikes'; $questionTypes [] = 'radio'; $questions [] = 'Should cyclists have their own lanes on roads?'; $questionOptions [] = 'Yes,No';
$questionNumbers [] = '5'; $questionSurveyNames [] = 'Bikes'; $questionTypes [] = 'radio'; $questions [] = 'Do you know how to ride a bike?'; $questionOptions [] = 'Yes,No';

$questionNumbers [] = '1'; $questionSurveyNames [] = 'Cars'; $questionTypes [] = 'text'; $questions [] = 'What is your favourite car make?'; $questionOptions [] = '';
$questionNumbers [] = '2'; $questionSurveyNames [] = 'Cars'; $questionTypes [] = 'text'; $questions [] = 'What is your favourite car body style?'; $questionOptions [] = '';
$questionNumbers [] = '3'; $questionSurveyNames [] = 'Cars'; $questionTypes [] = 'text'; $questions [] = 'What is your favourite car colour?'; $questionOptions [] = '';

$questionNumbers [] = '1'; $questionSurveyNames [] = 'TV'; $questionTypes [] = 'text'; $questions [] = 'do you watch tv?'; $questionOptions [] = '';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($questionNumbers); $i++)
{
	$sql = "INSERT INTO questions (questionNumber, surveyName, questionType, question, questionOptions) VALUES ('$questionNumbers[$i]', '$questionSurveyNames[$i]', '$questionTypes[$i]', '$questions[$i]', '$questionOptions[$i]')";

	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}
	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

$questionIDs [] = '25'; $answers [] = 'Lamborghini'; $answerUsernames [] = 'barrym'; $answerSurveyNames [] = 'Cars';
$questionIDs [] = '26'; $answers [] = 'Coupe';	$answerUsernames [] = 'barrym'; $answerSurveyNames [] = 'Cars';
$questionIDs [] = '27'; $answers [] = 'Grey';	$answerUsernames [] = 'barrym'; $answerSurveyNames [] = 'Cars';

$questionIDs [] = '1'; $answers [] = '3';	$answerUsernames [] = 'timmy'; $answerSurveyNames [] = 'Food';
$questionIDs [] = '2'; $answers [] = 'Pasta';	$answerUsernames [] = 'timmy'; $answerSurveyNames [] = 'Food';
$questionIDs [] = '3'; $answers [] = 'Turkey Bacon';	$answerUsernames [] = 'timmy'; $answerSurveyNames [] = 'Food';
$questionIDs [] = '4'; $answers [] = 'Sweet';	$answerUsernames [] = 'timmy'; $answerSurveyNames [] = 'Food';
$questionIDs [] = '5'; $answers [] = 'Seafood';	$answerUsernames [] = 'timmy'; $answerSurveyNames [] = 'Food';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($questionIDs); $i++)
{
	$sql = "INSERT INTO answers (questionID, answer, usernameAnswered, surveyName) VALUES ('$questionIDs[$i]', '$answers[$i]', '$answerUsernames[$i]', '$answerSurveyNames[$i]')";

	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}
	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}

$names [] = 'Sports';  $votes [] = '2';  $options [] = 'Football'; $usernameVoted [] = 'barrym';
$names [] = 'Sports';  $votes [] = '4';  $options [] = 'BasketBall'; $usernameVoted [] = 'barrym';
// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($options); $i++)
{

	$sql = "INSERT INTO samplePoll (name, votes, option, usernameVoted) VALUES ('$names[$i]', '$votes[$i]','$options[$i]', '$usernameVoted[$i]')";

	// no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql))
	{
		echo "row inserted<br>";
	}
	else
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}
// we're finished, close the connection:
mysqli_close($connection);
?>
