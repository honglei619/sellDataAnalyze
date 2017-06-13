<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL & ~E_NOTICE);

$action=$_GET['action'];
$types = $_GET['types'];

if($action == 'getItems'){
    getItems();
}else{

	getData($types);
}

function getData($types){

	require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}




$sql = "SELECT * FROM `filter` WHERE `物料类型`='$types'";

$get = $db -> query($sql);

$num_results = $get -> num_rows;



  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}


	echo json_encode($results,JSON_UNESCAPED_UNICODE);

}



function getItems(){

	require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}

$sql = "SELECT `物料类型` FROM `filter` WHERE 1 group by `物料类型`";

$get = $db -> query($sql);

$num_results = $get -> num_rows;

  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}


	echo json_encode($results,JSON_UNESCAPED_UNICODE);

}

?>