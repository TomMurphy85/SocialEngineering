<?php
//*****************************************
//Function to connect to SQL Database
//*****************************************
function connectToDatabase() 

// Function currently not working correctly.  Connection does not Persist beyond Function Call.
{
  // MySQL details
    $servername = "127.0.0.1:3306";
    $username = "u735717670_admin";
    $password = "V1hQXhICiQVk";
    $dbName = "u735717670_wi";
    
// Create MySQL connection
    $conn = mysqli_connect('p:'.$servername, $username, $password, $dbName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully <p>";
}

//*****************************************
//Function to Insert Data into SQL Database
//*****************************************
function writeToDatabase($tableName, $colNames, $colValues)

{
//connectToDatabase();

  // MySQL details
    $servername = "127.0.0.1:3306";
    $username = "u735717670_admin";
    $password = "V1hQXhICiQVk";
    $dbName = "u735717670_wi";
    
// Create MySQL connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


//Write to SQL Database
//TODO: add If statement to confirm user has not already submitted a suggestion
$sql = "INSERT INTO $tableName ($colNames) VALUES ($colValues);";

if ($conn->query($sql) === TRUE) 
{
  // echo "<p>New record created successfully<br><br>";
} 
else 
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}
//*****************************************
//function for sql select query
//*****************************************
function readFromDatabase($values, $tableName, $conditions)
{
//connectToDatabase();
//echo "Connected to readFromDatabase";
  // MySQL details
    $servername = "127.0.0.1:3306";
    $username = "u735717670_admin";
    $password = "V1hQXhICiQVk";
    $dbName = "u735717670_wi";

// Create MySQL connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (empty($conditions)) {
$conditions = "";
}
elseif (strlen($conditions)  > 0)
{
$conditions = " WHERE ".$conditions;
}

$sql = "SELECT $values FROM $tableName $conditions";
//echo $sql;
$result = mysqli_query($conn, $sql);

return($result);

}

//*****************************************
//Function to Update Data in the SQL Database
//*****************************************
function UpdateDatabase($tableName, $setValues, $condition)

{
//connectToDatabase();

  // MySQL details
    $servername = "127.0.0.1:3306";
    $username = "u735717670_admin";
    $password = "V1hQXhICiQVk";
    $dbName = "u735717670_wi";
    
// Create MySQL connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


//Write to SQL Database
$sql = "Update $tableName SET $setValues WHERE $condition";

if ($conn->query($sql) === TRUE) 
{
  // echo $sql;
} 
else 
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}

//*****************************************
//function to clear all event information
//*****************************************
function clearTable($tableName, $condition)
{
//connectToDatabase();

  // MySQL details
    $servername = "127.0.0.1:3306";
    $username = "u735717670_admin";
    $password = "V1hQXhICiQVk";
    $dbName = "u735717670_wi";
    
// Create MySQL connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


//Write to SQL Database
$sql = "delete FROM $tableName WHERE $condition";

if ($conn->query($sql) === TRUE) 
{
    echo "<p>Table Cleared";
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

//*****************************************
//function to create a password of pre-defined length
//*****************************************
function generatePassword() {
    $alphabet = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
//*****************************************
//function to Confirm Button Press
//*****************************************
function confirmAction() {
echo "button Pressed";
 confirm("Press a button!");
}
//*****************************************
//Functions for mechanics on castVote.php
//*****************************************
function showEvents($eventList)
{
echo '<table width="40%" class="data-table" >
		<thead>
			<tr>
				<th>No</th>
				<th style="display:none">ID</th>
				<th>Event Name</th>
				<th>Event Date</th>
				<th>Event Time</th>
				<th>Comments</th>
				<th>Event Phase</th>
			</tr>
		</thead>
		<tbody>';
		$no 	= 1;
		$total 	= 0;
	while ($row = mysqli_fetch_array($eventList))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);

			echo '<tr class="row">
					<td>'.$no.'</td>
                    <td style="display:none;">'.$row['eventID'].'</td>
					<td><a href="/castVote.php?eventID='.$row['eventID'].'">'.$row['eventName'].'</a></td>
					<td>'.$row['eventDate'].'</td>
					<td>'.$row['eventTime'].'</td>
					<td>'.$row['Comments'].'</td>
					<td>'.$row['eventPhase'].'</td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}
		echo '</tbody></table><br><br>';
}

//*****************************************
//Read and return single value from VoterInfo
//*****************************************
function ReadVoterInfo($eventID, $voterEmail, $Value)
{
    $voterQuery = readFromDatabase("*", "voterInfo", "voterEmail = '$voterEmail' && eventID = '$eventID'");
    while ($voterRow = mysqli_fetch_array($voterQuery))
    {
    	$amount         = $voterRow['amount'] == 0 ? '' : number_format($voterRow['amount']);
    switch ($Value) {
    case "Vote":
        $return = $voterRow['userVote'];
        break;
    case "Email":
        $return = $voterRow['voterEmail'];
        break;
    case "Attending":
        $return = $voterRow['userAttending'];
        break;
    case "Comment":
        $return = $voterRow['userComment'];
        break;    
    case "Submission":
        $return = $voterRow['userSubmission'];
        break;
    case "finalVote":
        $return = $voterRow['finalVote'];
        break;    
    case "Count":
        $return = mysqli_num_rows($voterQuery);
        break;    
    
}

        return $return;
    }
}

//*****************************************
//Function to show Nav bar at the top of each page.
//*****************************************
function displayNav($active)
{
$home = '';
$create = '';
$manage = '';
$vote = '';
switch($active)
{
case "home":
$home = "class='active'";
break;
case "create":
$create = "class='active'";
break;
case "manage":
$manage = "class='active'";
break;
case "vote":
$vote = "class='active'";
break;
}

    

$navBar = '<div class="topnav">
    <a '.$home.'    href="home.php">Home</a>
    <a '.$create.'  href="createEvent.php">Create Event</a>
    <a '.$manage.'   href="manageEvents.php">Manage Events</a>
    <a '.$vote.'    href="castVote.php">Cast Vote</a>
</div>';
return $navBar;
}
?>

