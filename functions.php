<?php
//*****************************************
//Function to connect to SQL Database
//*****************************************
function connectToDatabase() 

// Function currently not working correctly.  Connection does not Persist beyond Function Call.
{
  // MySQL details
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";
    
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
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";
    
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
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";

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
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";
    
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
   echo "<p>Row Updated successfully<br><br>";
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
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";
    
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
//Function to clear a row from a table based on passed ID, and SQL Table Name
//*****************************************
function deleteTableRow($tableName, $rowID)
{

//connectToDatabase();

  // MySQL details
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";
    $tableID = "";
// Create MySQL connection
    $conn = mysqli_connect($servername, $username, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//Switch to determine which Table is being altered

switch($tableName)
{
case "createEvent":
$tableID = "eventID";
break;
case "Users":
$tableID = "userID";
break;
case "voterInfo":
$tableID = "voteID";
break;
}
//Write to SQL Database
$sql = "delete FROM $tableName where $tableID = '$rowID'";

if ($conn->query($sql) === TRUE) 
{
    echo "<p>Row Deleted";
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn->error;
} 
}
?>
