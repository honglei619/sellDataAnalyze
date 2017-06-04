<?php
header("Content-Type: text/html; charset=utf-8");

/*
	$dateFrom = $_POST['dateFrom'];
  $dateTo = $_POST['dateTo'];
	$type = $_POST['type'];
	$filter = $_POST['filter'];
	$yearFrom = substr($dateFrom,0,4);
	$monthFrom = substr($dateFrom,5,2);
  $yearTo = substr($dateTo,0,4);
  $monthTo = substr($dateTo,5,2);
*/
    require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}
/*
$types = $_GET['types'];
$dateFrom = $_GET['dateFrom'];
$dateTo = $_GET['dateTo'];
$filter = $_GET['filter'];

$yearFrom = substr($dateFrom,0,4);
$monthFrom = substr($dateFrom,5,2);
$yearTo = substr($dateTo,0,4);
$monthTo = substr($dateTo,5,2);
*/
$month = $_GET['month'];
#sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价',ROUND(sum(`销售成本`)/10000,2) as '销售成本',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本',ROUND(sum(`销售运费`)/10000,2) as '销售运费' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` ='2016' group by `客户` order by sum(`销售数量(MT)`) DESC limit 5";
#$sql = "SELECT `$filter`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$types') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `$filter`";
$sql = "SELECT `品牌`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='糯米') and `会计年度` ='2017'  and `期间` = '$month' group by `品牌`";

$get = $db -> query($sql);

$num_results = $get -> num_rows;



  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}


	echo json_encode($results,JSON_UNESCAPED_UNICODE);

?>
