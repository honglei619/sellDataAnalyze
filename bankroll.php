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
//empty($_GET['types']) && $_GET['type'] = 0;
$types = $_GET['types']; //请求数据类型，判定执行sql,0,1,2

$yearFrom = $_GET['yearFrom'];
$monthFrom = $_GET['monthFrom'];
$yearTo = $_GET['yearTo'];
$monthTo = $_GET['monthTo'];
$filter = $_GET['filter'];

if($types ==0){
    $sql = "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(sum(`销售毛利(扣除运费)`)/10000 ,2)as '销售毛利(万元)' ,ROUND(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from maindata where `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo)*100,2) as '销量占比' ,ABS(ROUND(sum(`销售收入`)/(select sum(`销售收入`) from maindata where `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo)*100,2)) as '销售收入占比' ,ABS(ROUND(sum(`销售毛利(扣除运费)`)/(select sum(`销售毛利(扣除运费)`) from maindata where `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo)*100,2)) as '销售毛利占比' from `maindata` where `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `客户` order by sum(`$filter`) DESC limit 10";
}
if($types ==1){
$sql = "SELECT `会计年度` as '期间',sum(`销售收入`) as '收入',sum(`销售成本`) as '成本',sum(`销售毛利(调整后)`)as '利润',round(sum(`销售成本`)/sum(`销售收入`),2) as '成本率',round(sum(`销售毛利(调整后)`)/sum(`销售收入`),2) as '利润率' FROM `maindata` WHERE `会计年度` = $yearFrom union SELECT `会计年度` as '期间',sum(`销售收入`) as '收入',sum(`销售成本`) as '成本',sum(`销售毛利(调整后)`)as '利润',round(sum(`销售成本`)/sum(`销售收入`),2) as '成本率',round(sum(`销售毛利(调整后)`)/sum(`销售收入`),2) as '利润率' FROM `maindata` WHERE `会计年度` = $yearFrom-1";
}
if($types ==2){
    $sql = "SELECT '散油' as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE (`物料中类`='豆油'or `物料中类`='菜油'or `物料中类`='棕榈油'or`物料中类`='玉米油') and `会计年度`=$yearFrom union SELECT '粕' as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE `物料中类`like '%粕%' and `会计年度`=$yearFrom union SELECT '大米' as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE `物料中类`like '%米%' and `会计年度`=$yearFrom union SELECT `物料中类` as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE `物料中类`='小包装油' and `会计年度`=$yearFrom union SELECT `物料中类` as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE `物料中类`='中包装油' and `会计年度`=$yearFrom union   SELECT '其他' as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE `物料中类`='其他' and `会计年度`=$yearFrom union SELECT '合计' as '分类', sum(`销售数量(MT)`) as '销量', sum(`销售收入`) as '销售收入', round(sum(`销售数量(MT)`)/(select sum(`销售数量(MT)`) from `maindata` where `会计年度`=$yearFrom),2) as '销售收入占比', sum(`销售毛利`) as '销售毛利', round(sum(`销售毛利`)/(select sum(`销售毛利`) from `maindata` where `会计年度`=$yearFrom),2) as '销售毛利占比', round(sum(`销售毛利`)/sum(`销售收入`),2) as '毛利率' FROM `maindata` WHERE  `会计年度`=$yearFrom";
}
$get = $db -> query($sql);

$num_results = $get -> num_rows;



  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}


    echo json_encode($results,JSON_UNESCAPED_UNICODE);

?>
