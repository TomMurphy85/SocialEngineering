<?php
session_start();
include ('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
<meta name="google-signin-client_id" content="37124940865-21673adj5plibiqgdk8if7h14cqn866g.apps.googleusercontent.com">
</head>

<body>
<?php
$signOutView = "False";
$signUpView = "False";

    if (!empty($_SESSION["sessionEmail"]) || (isset($_GET['gpEmail'])))
    {
        echo displayNav("home");
	    if (!empty($_SESSION["sessionEmail"]))
	    {
            $userEmail = $_SESSION["sessionEmail"];
        }
    	else if (isset($_GET['gpEmail']))
    	{
    	    $userEmail = $_GET['gpEmail'];
    		$_SESSION["sessionEmail"] = $userEmail;
    		
    	}
    	else
    	{
    	   location.replace("signIn.php");
    	}
    	echo "Welcome ". $userEmail;
    	$logOutText = "";
    	$signUpView = "False";
    	$signOutView = "True";	

		//SQL Lookup to populate Page
    
            $eventQuery = readFromDatabase("eventID", "createEvent", "eventCreator = '$userEmail'");
            $eventNumRows = mysqli_num_rows($eventQuery);
            $voteQuery = readFromDatabase("eventID", "voterInfo", "voterEmail = '$userEmail'");
            $voteNum = mysqli_num_rows($voteQuery);
    }
    else
    {
        $signOutView = "False";
        $signUpView = "True";
    }
?>
    
    <div id="signOutDiv" <?php if ($signOutView == "False"){ echo 'style="display:none;"'; } ?>>
            <p><a href="createEvent.php">Create new events here.</a>.</p> 
            
            <p <?php if ($eventNumRows < 1){ echo 'style="display:none;"'; }?>><?php echo "You have ".$eventNumRows." events - " ?>  <a href="manageEvents.php">Manage your events here.</a>.</p>
            
            <p <?php if ($voteNum < 1){ echo 'style="display:none;"'; }?>><?php echo "You have ".$voteNum." events to vote on - " ?><a href="castVote.php">Vote on your events here.</a>.</p>
            
            <p><a href="#" onclick="signOut();">Sign out of Google API</a>.</p>
    </div>    
    <div data-onsuccess="onSignIn" id="signUpDiv" <?php if ($signUpView == "False"){ echo 'style="display:none;"'; } ?>>
             <p>Have an account? <a href="signIn.php">Sign into google account here</a>.</p>       
    </div>
  <script>
    function signOut() {
      var auth2 = gapi.auth2.getAuthInstance();
        auth2.disconnect().then(function () { 
        location.replace("signIn.php");
      });
    }

    function onLoad() {
      gapi.load('auth2', function() {
        gapi.auth2.init();
      });
    }
  </script>
</body>
</html>
