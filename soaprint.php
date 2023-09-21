<?php
include_once('report/tcpdf/tcpdf.php');
include_once('report/PHPJasperXML.inc.php');
include("inc/dbconn.php");
$version="0.8b";
$pgport=3306;
$pchartfolder="pchart2";
$pid = $_GET['id'];
$xml =  simplexml_load_file("report/report.jrxml");
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->sql ="call print_soa('$pid')";
$PHPJasperXML->transferDBtoArray($host,$username,$password,$db_name);
ob_end_clean();
$PHPJasperXML->outpage("I");
?>