<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<head>
	<meta charset="utf-8" />
</head>
<style type="text/css">
table.hovertable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #999999;
	border-collapse: collapse;
}
table.hovertable th {
	background-color:#c3dde0;
	border-width: 1px;
    width: 140px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
table.hovertable tr {
	background-color:#d4e3e5;
}
table.hovertable td {
	border-width: 1px;
    width: 140px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
</style>

<form action ="table.php" method = "post">
	<font size = "3">报表开始时间段</font>

	<input type="text" name = "dateFrom" class="Wdate" value="2017-5" onfocus="WdatePicker({dateFmt:'yyyy-M',minDate:'2016-1',maxDate:'2017-12'})"/>
    <font size = "3">报表结束时间段</font>
    <input type="text" name = "dateTo" class="Wdate" value="2017-5" onfocus="WdatePicker({dateFmt:'yyyy-M',minDate:'2016-1',maxDate:'2017-12'})"/>

	<font size = "3">报表类型</font>
					<select name ="type">
                    <option value = "糯米"  maxlength = "20" size = "10">糯米</option>
                    <option value = "粳米"  maxlength = "20" size = "10">粳米</option>
                    <option value = "籼米"  maxlength = "20" size = "10">籼米</option>
                    <option value = "大米"  maxlength = "20" size = "10">大米</option>
          </select>
    <font size = "3">筛选类型</font>
					<select name ="filter">

                    <option value = "事业部"  maxlength = "20" size = "10">事业部</option>
                    <option value = "品牌"  maxlength = "20" size = "10">品牌</option>
                    <option value = "规格"  maxlength = "20" size = "10">规格</option>
                    <option value = "自产·贸易"  maxlength = "20" size = "10">自产·贸易</option>
                    <option value = "客户类型"  maxlength = "20" size = "10">客户类型</option>
                    <option value = "客户销量排名"  maxlength = "20" size = "10">客户销量排名</option>
                    <option value = "客户利润排名"  maxlength = "20" size = "10">客户利润排名</option>
                    <option value = ""  maxlength = "20" size = "10">空</option>
          </select>
	<input type = "submit" value = '生成报表'>
</form>

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<?php

	$dateFrom = $_POST['dateFrom'];
  $dateTo = $_POST['dateTo'];
	$type = $_POST['type'];
	$filter = $_POST['filter'];
	$yearFrom = substr($dateFrom,0,4);
	$monthFrom = substr($dateFrom,5,2);
  $yearTo = substr($dateTo,0,4);
  $monthTo = substr($dateTo,5,2);

	echo '报表取数时间：'.$yearFrom.'年'.$monthFrom.'月到'.$yearTo.'年'.$monthTo.'月';
	echo '<br></br>';
	echo '<font color = "red">'.$type.'</font>品项';
	echo '按<font color = "red">'.$filter.'</font>筛选';

    require_once 'connectvars.php';
    @ $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_error()) {
		echo "could not connect to db";
		exit;
	}
if ($type =="大米") {

    $sql = "SELECT filter.`物料类型`,ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `filter`,`maindata` where `物料描述` IN (select `物料` from `filter` where 1 ) and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by filter.`物料类型`";
    $sql_lastMonth = "SELECT filter.`物料类型`,ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `filter`,`maindata` where `物料描述` IN (select `物料` from `filter` where 1 ) and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by filter.`物料类型`";

}elseif ($filter == "客户销量排名") {


        $sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `客户` order by sum(`销售数量(MT)`) DESC";

    }
elseif($filter == "客户利润排名"){

    $sql= "SELECT `客户`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `客户` order by sum(`销售毛利(扣除运费)`) DESC";
}
elseif($filter != "客户销量排名"||$filter != "客户利润排名"){

	$sql = "SELECT `$filter`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `$filter`";
	$sql_lastMonth = "SELECT `$filter`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `$filter`";
    $sql_lastYear = "SELECT `$filter`, ROUND(sum(`销售数量(MT)`),2) as '销量(吨)',ROUND(sum(`销售收入`)/10000,2) as '销售收入(万元)',ROUND(avg(`销售收入`)/avg(`销售数量(MT)`),2) as '吨均售价(元/吨)',ROUND(sum(`销售成本`)/10000,2) as '销售成本(万元)',ROUND(avg(`销售成本`)/avg(`销售数量(MT)`),2) as '吨均成本(元/吨)',ROUND(sum(`销售运费`)/10000,2) as '销售运费(万元)' ,ROUND(avg(`销售运费`)/avg(`销售数量(MT)`),2) as '吨均运费(元/吨)',ROUND(sum(`销售毛利`)/10000 ,2)as '销售毛利(万元)',ROUND(avg(`销售毛利`)/avg(`销售数量(MT)`),2) as '吨均毛利(元/吨)' from `maindata` where `物料描述` IN (select `物料` from `filter` where `物料类型`='$type') and `会计年度` between $yearFrom and $yearTo and `期间` between $monthFrom and $monthTo group by `$filter`";

}

$get = $db -> query($sql);
$get_lastMonth = $db -> query($sql_lastMonth);
$get_lastYear = $db -> query($sql_lastYear);
$num_results = $get -> num_rows;
$num_results_lastMonth = $get_lastMonth -> num_rows;
$num_results_lastYear = $get_lastYear -> num_rows;
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

for ($i=0; $i <$num_results ; $i++) {
    $result = $get -> fetch_assoc();
    if ($i==0) {
    	echo '<table class="hovertable">';
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
foreach ($result as $key => $value) {
    		//echo '<th>'.$year.'-'.$month.$key.'</th>';
            echo '<th>'.$key.'</th>';
    	}
    	echo '</tr>';
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
foreach ($result as $key => $value) {
    		echo '<td>'.$value.'</td>';
    	}
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
}
   else{
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";

        foreach ($result as $key => $value) {

    		echo '<td>'.$value.'</td>';

    	}
    	echo '</tr>';
        echo '</tr>';
    }
}

for ($i=0; $i <$num_results_lastMonth ; $i++) {
    $result_lastMonth = $get_lastMonth -> fetch_assoc();
    if ($i==0) {
        echo '<table class="hovertable">';
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
foreach ($result_lastMonth as $key => $value) {
            //echo '<th>'.$year.'-'.($month-1).$key.'</th>';
            echo '<th>'.$key.'</th>';
        }
        echo '</tr>';
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
foreach ($result_lastMonth as $key => $value) {
            echo '<td>'.$value.'</td>';
        }
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
}
   else{
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";

        foreach ($result_lastMonth as $key => $value) {

            echo '<td>'.$value.'</td>';

        }
        echo '</tr>';
        echo '</tr>';
    }
}

for ($i=0; $i <$num_results_lastYear ; $i++) {
    $result_lastYear = $get_lastYear -> fetch_assoc();
    if ($i==0) {
        echo '<table class="hovertable">';
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
foreach ($result_lastYear as $key => $value) {
            //echo '<th>'.($year-1).'-'.$month.$key.'</th>';
            echo '<th>'.$key.'</th>';
        }
        echo '</tr>';
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
foreach ($result_lastYear as $key => $value) {
            echo '<td>'.$value.'</td>';
        }
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";
}
   else{
echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">\n";

        foreach ($result_lastYear as $key => $value) {

            echo '<td>'.$value.'</td>';

        }
        echo '</tr>';
        echo '</tr>';
    }
}

?>
