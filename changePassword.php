<?php

  require_once "header.php";

  //message becomes empty so no error shown
  $message = "";

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

      echo <<<_END
      to update the details of user, please select which user and attribute you would like to update:

      <br><br>
      <!-- button for change password -->
      <form action = "changePassword.php" method = "POST">
      <label> Username: </label>
      <input type = "text" name = "usernamePasswordChange">

       <label> please input the new password: </label>

      <input type = "text" name = "newPassword">
      <button = "submit" value = "Update"> Change</button>
      </form>

      <!-- button to retun b=to admin tools -->
      <form action="admin.php">
      	<button name="adminReturnButton" type="submit" value="return">Return to Admin tools</button>
      </form>
_END;
      //if password change button pressed, update the user account
      if(isset($_POST['newPassword']))
      {
        $query = "UPDATE users SET password = '{$_POST['newPassword']}' WHERE username = '{$_POST['usernamePasswordChange']}'";
        $result = mysqli_query($connection, $query);

        if ($result)
        {
          $message = "password changed";
        }
        else
        {
          $message = "password not changed";
        }
      }
      mysqli_close($connection);
      echo $message;
    }
  }
  require_once "footer.php";
?>
