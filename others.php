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


$yearFrom = $_GET['yearFrom'];
$monthFrom = $_GET['monthFrom'];
$yearTo = $_GET['yearTo'];
$monthTo = $_GET['monthTo'];
$types = $_GET['types'];
$filter = $_GET['filter'];

if ($filter=="客户销量排名") {
	
$sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$types') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `客户` order by sum(`销售数量(MT)`) DESC limit 5";

}else if($filter == "客户利润排名"){
$sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$types') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `客户` order by sum(`销售毛利`) DESC limit 5";
}elseif($types == "散油"){
 
 $sql = "SELECT `物料小小类`as '物料名称', ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='豆油' or `物料类型`='棕榈油' or`物料类型`='菜油' or`物料类型`='棉油'or`物料类型`='玉米油' or `物料类型`='葵油') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `物料小小类` ";


}elseif($types == "粕"){
	$sql = "SELECT `物料小小类` as '物料名称', ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='棕榈粕' or `物料类型`='豆粕' or`物料类型`='菜饼' or`物料类型`='豆皮'or`物料类型`='其他') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `物料小小类` ";

}else $sql = "SELECT `$filter`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$types') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `$filter`";


$get = $db -> query($sql);

$num_results = $get -> num_rows;



  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}


	echo json_encode($results,JSON_UNESCAPED_UNICODE);

?>