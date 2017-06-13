<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL & ~E_NOTICE);


$action=$_GET['action'];
$types = $_GET['types'];
$input_types = $_GET['input_types'];
$input_items = $_GET['input_items'];
$input_id = $_GET['input_id'];

if($action == 'getItems'){
    getItems();
}else if($action=='getData'){
	getData($types);
}else if($action == 'addData'){
	addData($input_types,$input_items);
}else if($action=='removeData'){
	removeData($input_id);
};




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

function addData($input_types,$input_items){

	require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}
if($input_types&&$input_items != ""){
	$sql = "INSERT INTO `filter`( `物料类型`, `物料`) VALUES ('$input_types','$input_items')";
	$get = $db -> query($sql);}
	//echo '============='.$input_items.$input_types;
}

function removeData($input_id){

		require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}

	$sql = "DELETE FROM `filter` WHERE id ='$input_id'";
	$get = $db -> query($sql);
	echo "--------------".$input_id;
}

?>