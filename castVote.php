<!DOCTYPE HTML>  
<?php
session_start();
include ('functions.php');
$voterEmail = "";
$voteDisp = "display:none";
$emaildisp = "display:block";
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<?php 
if (!empty($_SESSION["sessionEmail"]))
{
    echo displayNav("vote");
    $voterEmail = $_SESSION["sessionEmail"];
    $emailQuery = readFromDatabase("eventID", "voterInfo", "voterEmail = '$voterEmail'");
    $listRows =  mysqli_num_rows($emailQuery);
    $count = 0;
		while ($lookUpRow = mysqli_fetch_array($emailQuery))
		{
			$amount  = $lookUpRow['amount'] == 0 ? '' : number_format($lookUpRow['amount']);
            if ($count == 0) //First EventID
            {
              $userEvents = $userEvents.$lookUpRow['eventID']."' or eventID = '";  
              $count++;
            }
            elseif ($count == ($listRows -1)) //Last EventID
            {
            	$userEvents = $userEvents.$lookUpRow['eventID'];
            	$count++;
            }
            else //All other EventIDs
            {
                $userEvents = $userEvents.$lookUpRow['eventID']."'" . " or eventID = '"; 
                $count++;
            }
        }

if (isset($_GET['eventID'])) //When eventID is passed through URL
{
    $eventID = $_GET['eventID'];
    $_SESSION["eventID"] = $eventID;
    $nameQuery = readFromDatabase("eventName", "createEvent", " eventID = '$eventID'");
    $nameRow = mysqli_fetch_array($nameQuery);
    $eventName = $nameRow[0];
    $voteQuery = readFromDatabase("*", "voterInfo", " eventID = '$eventID' && userSubmission <> ''");
    
    $finalVoteQuery = readFromDatabase("*, COUNT(userVote)", "voterInfo", " eventID = '$eventID' && userSubmission <> '' GROUP BY userVote ORDER BY COUNT(userVote) DESC LIMIT 2");
    $winningVoteQuery = readFromDatabase("*, COUNT(finalVote)", "voterInfo", " eventID = '$eventID' && userSubmission <> '' GROUP BY userVote ORDER BY COUNT(userVote) DESC LIMIT 1");
}
//---Display All Events User is part of
echo '<h1>Events you were invited to</h1>';
    $eventList = readFromDatabase("*", "createEvent", " eventID = '$userEvents'");
    showEvents($eventList);
	//if there are no rows, show error    
	    if($listRows == 0 && !isset($_GET['eventID'])) 
	    {
	        echo "Your email is not assigned to any Events.";
        } 
//---End Display All Events---
    
}
else
    {
    echo '<a href="signIn.php">Something went wrong, please sign in again here</a>';
    }
?>
<?php
		//--- Get Selected Phase ---
		$getPhase = readFromDatabase("eventPhase", "createEvent", " eventID = '$eventID'");
        $phaseRow = mysqli_fetch_array($getPhase);
        $phase = $phaseRow[0];
        
        //--- See if user already submitted a request ---
        $getSubmission = ReadVoterInfo($eventID, $voterEmail, "Submission"); 
        $getAttending = ReadVoterInfo($eventID, $voterEmail, "Attending");
        if (!isset($getAttending))
        {$attendingMsg = "Are you attending this Event?";}
        else
        {$attendingMsg = "Your current RSVP status is: '".$getAttending."'";}
        
        
        $getVoteID = ReadVoterInfo($eventID, $voterEmail, "Vote");
        $getfinalVote = ReadVoterInfo($eventID, $voterEmail, "finalVote");
        //Hide Vote Button if Phase is Submission
        $hideFinalVote = 'style="display: none;"';
        $hideVoteBtn = 'style="display: none;"';	
        $hideVote = 'style="display: none;"';
        $hideSuggestion = 'style="display: none;"';
        $hideFinalBtn = 'style="display: none;"';
        $hideClosed = 'style="display: none;"';
        switch ($phase) {
            case "Submission":
                $hideVote = '';
        		if (!isset($getSubmission))
        		$hideSuggestion = '';
                break;
            case "firstVote":
                $hideVote = '';
                if (!isset($getVoteID))
        			$hideVoteBtn = '';
                break;
            case "finalVote":
        		$hideFinalVote = '';
        		$hideVote  = 'style="display: none;"';
        		if (!isset($getfinalVote))
        		$hideFinalBtn = '';	
                break;
            case "voteClosed":
            	$hideVote  = 'style="display: none;"';
        		$hideClosed = '';
                break;    
        	default:
        $hideFinalVote = 'style="display: none;"';
        $hideVoteBtn = 'style="display: none;"';	
        $hideVote = 'style="display: none;"';
        $hideSuggestion = 'style="display: none;"';
        $hideFinalBtn = 'style="display: none;"';
        $hideClosed = 'style="display: none;"';	
        }
?>
<!-- Attending RSVP -->

<!-- Table to cast vote -->
 <div id="tblCastVote" <?php echo $hideVote; ?>>
     <h1><?php echo '"'.$eventName.'" Vote Options'; ?></h1>
     <center>
    <?php echo $attendingMsg ?>
    <br>
    <?php viewRSVP(); ?>
<br>
     </center>
	<table width="40%" class="data-table" >
		<thead>
			<tr>

				<th>No</th>
				<th style="display:none">ID</th>
				<th>Suggestion</th>
				<th>Comment</th>
				<th <?echo $hideVoteBtn; ?>>Vote</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if ($eventID <> "DB")
		{
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($voteQuery))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td width="10%"><center>'.$no.'</center></td>
					<td style="display:none;">'.$row['voteID'].'</td>
					<td><center>'.$row['userSubmission'].'</center></td>
					<td><center>'.$row['userComment'].'</center></td>
					<td width="10%"'. $hideVoteBtn.'><form method="post" action="" >
					<input type="submit" name="castVote" value="Vote"/>
					<input type="hidden" name="id" value="'.$row['voteID'].'"/>
					</form></td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}
		}?>
		</tbody>
	</table>
</div>
<!-- Table for Final Vote -->
 <div id="tblCastVote" <?php echo $hideFinalVote; ?>>
     <h1><?php echo '"'.$eventName.'" Final Vote'; ?></h1>
     <center>
     <?php echo $attendingMsg ?>
     <br>
     <?php viewRSVP(); ?>
<br>
     </center>
	<table width="40%" class="data-table" >
		<thead>
			<tr>

				<th>No</th>
				<th style="display:none">ID</th>
				<th>Suggestion</th>
				<th>Comment</th>
				<th <?echo $hideFinalBtn; ?>>Vote</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if ($eventID <> "DB")
		{
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($finalVoteQuery))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td width="10%"><center>'.$no.'</center></td>
					<td style="display:none;">'.$row['voteID'].'</td>
					<td><center>'.$row['userSubmission'].'</center></td>
					<td><center>'.$row['userComment'].'</center></td>
					<td width="10%"'. $hideFinalBtn.'><form method="post" action="" >
					<input type="submit" name="castFinal" value="Vote"/>
					<input type="hidden" name="finalID" value="'.$row['voteID'].'"/>
					</form></td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}
		}?>
		</tbody>
	</table>
</div>

<!-- Form to add Suggetsions to the Event -->
<div <?php echo $hideSuggestion;  ?>>
<center>
<h2>Add Suggestions</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Suggestions: <textarea name="Suggestion" rows="1" cols="30"><?php echo $suggestion;?></textarea>
  <span class="error">* <?php echo $eventNameErr;?></span>
  <br><br>
Comment: <textarea name="suggestcomment" rows="5" cols="40"><?php echo $suggestComment;?></textarea>
  <br><br>
  <input type="hidden" name="eventID" value="<?php echo $eventID; ?>" /> 
   <input type="submit" name="submitSuggestion" value="Submit Suggestion">
</form>
</center>
</div>

 <div id="tblCastVote" <?php echo $hideClosed; ?>>
     <h1><?php echo '"'.$eventName.'" Voting Closed'; ?></h1>
     <center>
     <?php echo $attendingMsg ?>
     <br>
     <?php viewRSVP(); ?>
<br>
     </center>
	<table width="40%" class="data-table" >
		<thead>
			<tr>

				<th style="display:none">ID</th>
				<th>Winning Suggestion</th>
				<th>Comment</th>
				<th># of Votes</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if ($eventID <> "DB")
		{
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($winningVoteQuery))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td style="display:none;">'.$row['voteID'].'</td>
					<td><center>'.$row['userSubmission'].'</center></td>
					<td><center>'.$row['userComment'].'</center></td>
					<td><center>'.mysqli_num_rows($winningVoteQuery).'</center></td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}
		}?>
		</tbody>
	</table>
</div>

<?php 
//get Attending DropDown Value
$attending = '';
$tempEventID = $_POST['eventID'];
if ($_POST['attendYes'])
{
   $attending = "Yes";
}
elseif ($_POST['attendNo'])
{
   $attending = "No";
}
elseif ($_POST['attendMaybe'])
{
   $attending = "Maybe";
}
if ($attending <> '') //User RSVPed to event
{
UpdateDatabase('voterInfo', "userAttending = '$attending'" , "voterEmail = '$voterEmail' && eventID = '$eventID'");
header("Refresh:0");
}
//Update SQL DB with Vote Choice
if (($_POST['castVote']  && $_POST['id']))
  {
    $userVoteID = $_POST['id'];  
    UpdateDatabase('voterInfo', "userVote = '$userVoteID'", "voterEmail = '$voterEmail' && eventID = '$eventID'");
    header("Refresh:0");
  }

//Update DB to include user final vote
if (($_POST['castFinal']  && $_POST['finalID']))
  {
    $finalVoteID = $_POST['finalID'];  
    UpdateDatabase('voterInfo', "finalVote = '$finalVoteID'", "voterEmail = '$voterEmail' && eventID = '$eventID'");
    header("Refresh:0");
  }

if (isset($_POST['submitSuggestion']))
{
$suggestion = $_POST['Suggestion'];
$suggestComment = $_POST['suggestcomment'];
if (isset($suggestion) && isset($tempEventID))
{
    UpdateDatabase('voterInfo', "userSubmission = '$suggestion', userComment = '$suggestComment'" , "voterEmail = '$voterEmail' && eventID = '$tempEventID'");
}
else
echo "Suggestion must not be blank";
}

function viewRSVP()
{
echo'    <div>
<form method="post" action="">
	<input type="submit" name="attendYes" value="Yes"/>
	<input type="submit" name="attendNo" value="No"/>
	<input type="submit" name="attendMaybe" value="Maybe"/>
</form>
</div>';
}
?>
</body>
</html>