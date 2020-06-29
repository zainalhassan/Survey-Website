<?php

  require_once "header.php";

  // default values we show in the form:
  $updateUsername = "";
  $updateAttribute = "";
  $updateAttributeData = "";

  // strings to hold any validation error messages:
  $updateUsername_val = "";
  $updateAttribute_val = "";
  $updateAttributeData_val = "";

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
      <br>
      <form action = "update.php" method = "POST">
      Username: <input type="text" name="usernameUpdate" minlength = "1" maxlength="16" value="$updateUsername" required> $updateUsername_val
      Attribute: <input type = "text" name = "attributeUpdate" minlength = "1" maxlength="16" value = "$updateAttribute" required> $updateUsername_val
      New data: <input type = "text" name = "updatedData" minlength = "1" maxlength="64" value = "$updateAttributeData" required> $updateAttributeData_val
      <button name = "update" type = "submit" value = "Update"> Update </button>
      </form>

      <form action="admin.php">
      	<button name="adminReturnButton" type="submit" value="return">Return to Admin tools</button>
      </form>
_END;

  if(isset($_POST['update']))
  {
    //shouldnt be like this though, need a dynamic drop down menu for both usernames and the attributes of the table - users.
  //   echo <<<_END
  //     Attribute: <select name = "chooseUsername">
  //     <option value="$updateAttribute = username">Username</option>
  //     <option value="$updateAttribute = password">Password</option>
  //     <option value="$updateAttribute = firstName">First Name</option>
  //     <option value="$updateAttribute = lastName">Last Name</option>
  //     <option value="$updateAttribute = email">Email</option>
  //     <option value="$updateAttribute = dob">Date of Birth</option>
  //     <option value="$updateAttribute = telephone">Telehone</option>
  //     </select>
  // _END;

  $updateUsername = sanitise($_POST['usernameUpdate'], $connection);
  $updateAttribute = sanitise($_POST['attributeUpdate'], $connection);
  $updateAttributeData = sanitise($_POST['updatedData'],$connection);

  $updateUsername_val = validateString($updateUsername, 1, 16);
  $updateAttribute_val = validateString($updateAttribute,1,16);
  $updateAttributeData_val = validateString($updateAttributeData,1,16);

  // concatenate all the validation results together ($errors will only be empty if ALL the data is valid):
  $errors = $updateUsername_val . $updateAttribute_val . $updateAttributeData_val;

  // check that all the validation tests passed before going to the database:
  if ($errors == "")
  {
    $query = "UPDATE users SET {$_POST['attributeUpdate']} = '{$_POST['updatedData']}' WHERE username = '{$_POST['usernameUpdate']}'";
    $result = mysqli_query($connection, $query);

    if ($result)
    {
      $message = "user account updated";
    }
    else
    {
      $message = "user account not updated";
    }
  }

  mysqli_close($connection);
  echo $message;
}
}
}
require_once "footer.php";
?>
