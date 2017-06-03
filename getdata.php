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
$type = $_GET['mi'];


$sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价',ROUND(sum(`销售成本`)/10000,2) as '销售成本',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本',ROUND(sum(`销售运费`)/10000,2) as '销售运费' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` ='2016' group by `客户` order by sum(`销售数量(MT)`) DESC limit 10";

$get = $db -> query($sql);

$num_results = $get -> num_rows;



  while($current = $get -> fetch_assoc()){
			$results[] = $current;
	}
  #var_export($results);
	echo json_encode($results,JSON_UNESCAPED_UNICODE);

/*
for ($i=0; $i <$num_results; $i++) {

   global $current;
   $current = $get -> fetch_assoc();
   var_export($current);
   echo'<br></br>';
}

var_export($current);


class myData{
    public $title;
    public $sellData;
    public $sellMoney;
    public $avgSellMoney;
    public $sellCost;
    public $avgCost;
    public $sellFreight;
    public $avgFreight;
    public $sellMargin;
    public $avgMargin;

}

$data="";

    while($current = $get -> fetch_assoc()){
        $myData = new myData();
        $myData -> title = $current[$filter];
        $myData -> sellData = $current["销量(吨)"];
        $myData -> sellMoney = $current['销售收入(万元)'];
        $myData -> avgSellMoney = $current['吨均售价(元/吨)'];
        $myData -> sellCost = $current['销售成本(万元)'];
        $myData -> avgCost = $current['吨均售价(元/吨)'];
        $myData -> sellFreight = $current['销售运费(万元)'];
        $myData -> avgFreight = $current['吨均运费(元/吨)'];
        $myData -> sellMargin = $current['销售毛利(万元)'];
        $myData -> avgMargin = $current['吨均毛利(元/吨)'];
        $data[]=$myData;
  }
//var_export($data);

for ($i=0; $i < count($data); $i++) {
    echo '-'.$data(i);
    echo '<br></br>';
}
*/

?>
