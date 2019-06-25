<?php
include ('functions.php');
session_start();

// Define variables and initialize with empty values
$userEmail = $password = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["userEmail"]))){
	$login_err = "Please enter an Email Address.";
    } else{
        $userEmail = trim($_POST["userEmail"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $login_err = "Please enter a password.";     
    } else{
        $password = trim($_POST["password"]);
    }

$query = readFromDatabase("*", "Users", "userEmail = '$userEmail' && userPassword = '$password'");
$numRows = mysqli_num_rows($query);  
//$row = mysqli_fetch_array($query);

		  if($numRows == 0){
                    $login_err = "Your Login Name or Password is invalid";
                } else{
				$_SESSION["sessionEmail"] = $userEmail;         	    
//Determine if user has any existing events
		$eventQuery = readFromDatabase("*", "createEvent", "eventCreator = '$userEmail'");
			  if (!empty($_SESSION['redirectLink'])){
				$redirect = $_SESSION['redirectLink'];
				header("location: $redirect");
			}
			  elseif (mysqli_num_rows($eventQuery) == 0){
				header('location: createEvent.php'); 
			} else{
			 	header('location: manageEvents.php');	
			}
	
                }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Log In</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($userEmail_err)) ? 'has-error' : ''; ?>">
                <label>Email Address</label>
                <input type="text" name="userEmail" class="form-control" value="<?php echo $userEmail; ?>">
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $login_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Don't have an account? <a href="signUp.php">Sign up here</a>.</p>
        </form>
    </div>    
</body>
</html>
