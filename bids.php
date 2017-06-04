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
$servername = "localhost";
$username = "test";
$password = "t3st3r123";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT MAX(bid) AS max_bid, user_id FROM jahhundoBids";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
    while($row = $result->fetch_assoc()) {
        $max_bid = $row["max_bid"];
		$max_id = $row["user_id"];
    }
} else {
    echo "Suurimat pakkumist pole";
}
$conn->close();

$sql = "SELECT username FROM jahhundoUser WHERE user_id=" . $max_id;
echo $sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
    while($row = $result->fetch_assoc()) {
        $user_name = $row["username"];
    }
} else {
    echo "Suurimat pakkumist pole";
}
$conn->close();
?>
<body>
<div class="container">
<h2>Suurima pakkuja andmed: </h2>
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Pakkuja kasutajanimi:  <?php echo $max_id ?></strong></div>
        <div class="panel-body">Suurim pakkumine: <?php echo $user_name?></div>
    </div>
</div>

</body>
</html>