<?php
header("Content-Type: text/html; charset=utf-8");

    require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}
$sql = "SELECT * FROM `filter` WHERE 1";

$get = $db -> query($sql);

$num_results = $get -> num_rows;



  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}


	echo json_encode($results,JSON_UNESCAPED_UNICODE);

?>