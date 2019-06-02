<?php

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

$sql = 'SELECT * FROM votingOptions';
		
$query = mysqli_query($conn, $sql);

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}
?>
<html>
<head>
	<title>Displaying MySQL Data in HTML Table</title>
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: right;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
	</style>
</head>
<body>
	<table class="data-table">
		<caption class="title">Social Engineering: Cast Vote for Location</caption>
		<thead>
			<tr>

				<th>No</th>
				<th>ID</th>
				<th>Vote</th>				
				<th>Location</th>
				<th>Comment</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($query))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td>'.$no.'</td>
					<td>'.$row['ID'].'</td>
					<td>'."<input type=\"radio\" name=\"voteBtn\" value=\"voteBtn\"/>".'</td>
					<td>'.$row['Location'].'</td>
					<td>'.$row['userComment'].'</td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>

<center><br><input type="submit" name="submit" value="Cast Vote">
</center>	

<?php 
//Register Vote and write to Database.  Currently not working, isn't catching isset() for submit button.
if (isset($_POST['submit'])) 
{
if(isset($_POST['voteBtn']))
{
echo "You have selected :".$_POST['radio'];  //  Displaying Selected Value
}
}
?>
</body>
</html>
