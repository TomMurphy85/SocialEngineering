<?php
include ('functions.php');
session_start();
$_SESSION["sessionEmail"] = "";
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="37124940865-21673adj5plibiqgdk8if7h14cqn866g.apps.googleusercontent.com">
</head>
<body>
<div class="g-signin2" data-onsuccess="onSignIn"></div>
<script>
    function onSignIn(googleUser) 
        {
            var profile = googleUser.getBasicProfile();
            //  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            //  console.log('Name: ' + profile.getName());
            //  console.log('Image URL: ' + profile.getImageUrl());
              console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present. 

             location.replace("home.php?gpEmail=" + profile.getEmail());
        }
</script>

</body>
</html>