<!doctype html>
<html>
<head>
    <title>Pakkumised</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
// kood on osaliselt võetud: https://www.w3schools.com/php/php_mysql_select.asp

$servername = "localhost";
$user = "test";
$password = "t3st3r123";
$dbname = "test";

if(isset($_POST["username"]) && isset($_POST["bid"])) {
	
	$username = htmlspecialchars($_POST["username"]);
	$bid = htmlspecialchars($_POST["bid"]);
	
	// Create connection
	$conn = new mysqli($servername, $user, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO jahhundoBids (bid, user_name) VALUES 
(?, ?)");
	$stmt->bind_param("ds", $bid, $username);

	// execute
	$stmt->execute();

	$stmt->close();
	$conn->close();
}

// Create connection
$conn = new mysqli($servername, $user, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT MAX(bid) AS max_bid
FROM jahhundoBids";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
    while($row = $result->fetch_assoc()) {
        $max_bid = $row["max_bid"];
    }
} else {
    echo "Suurimat pakkumist pole";
}
$conn->close();

	// Create connection
	$conn = new mysqli($servername, $user, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// prepare and bind
	$stmt = $conn->prepare("SELECT user_name FROM jahhundoBids WHERE bid=?");
	$stmt->bind_param("s", $max_bid);
	
	
	// execute
	$stmt->execute();
	
	$result = $stmt->get_result();
	
	while($row = $result->fetch_assoc()) {
		$user_name = $row["user_name"];
	}

	$stmt->close();
	$conn->close();
?>
<body>

<div class="container">
<div>
<form method="post" action="">

<div>Kasutajanimi: <input type="text" name="username"></input></div>
<div>Pakkumine: <input type="text" name="bid"></input></div>
<div><button type="submit">Lisa pakkumine</button></div>
</form>
</div>
<h2>Suurima pakkuja andmed: </h2>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Pakkuja kasutajanimi:  <?php echo $user_name?></strong></div>
        <div class="panel-body">Suurim pakkumine: <?php echo $max_bid ?></div>
    </div>
</div>

</body>
</html>