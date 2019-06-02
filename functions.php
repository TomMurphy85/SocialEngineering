<?php

function connectToDatabase() 
//Function to connect to SQL Database
// Function currently not working correctly.  Connection does not Persist beyond Function Call.
{
  // MySQL details
    $servername = "localhost";
    $username = "root";
    $password = "osboxes.org";
    $dbName = "socialEngineering";
    
// Create MySQL connection
    $pconn = mysqli_connect('p:'.$servername, $username, $password, $dbName);
// Check connection
if ($pconn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully <p>";
}

//Function to Insert Data into SQL Database

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
    echo "<p>New record created successfully";
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

function readFromDatabase($tableName)
{
//connectToDatabase();
echo "Connected to readFromDatabase";
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

$sql = "SELECT enteredBy FROM $tableName";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "name: " . $row["enteredBy"]. "<br>";
    }
} else {
    echo "Zero results";
}

}

function clearTable($tableName)
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
$sql = "delete FROM $tableName";

if ($conn->query($sql) === TRUE) 
{
    echo "<p>Table Cleared";
} 
else 
{
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>
