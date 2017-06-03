<?php

header("Content-Type: text/html; charset=utf-8");

    require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}
	$year = 2016;
	$month = 1;
	//$type = $_POST['mi'];
  $type = $_GET['mi'];
  //$type = '糯米';
  //echo $type;
    #$sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量（吨）',ROUND(sum(`销售收入`)/10000,2) as '销售收入（万元）',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价（元/吨）',ROUND(sum(`销售成本`)/10000,2) as '销售成本（万元）',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本（元/吨）',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元）' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费（元/吨）',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利（万元）',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利（元/吨）' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` = $year and `期间`= $month group by `客户` order by sum(`销售毛利`) DESC";
    $sql = "select `期间`, sum(`销售数量(MT)`) as '销量' ,ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`= '$type' ) and `会计年度` = $year group by `期间` order by `期间`";

    $get = $db ->query($sql);
    //$results = $get -> num_rows;

    while($row = $get -> fetch_assoc()){
    $data[]=$row;
  }

echo json_encode($data,JSON_UNESCAPED_UNICODE);  //echo $data;

?>
