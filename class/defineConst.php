<?php
/*
Section of paging
*********************************************************************************************************/
$PageSize   =15;
$PageNo     =$_GET['PageNo'];
$Pagenumber =10;
$ModePaging ="Full";
/*Setting language
*******************************************************************************************************/
$arraySMTPSERVER=array("host"=>"mail.giaiphaptoiuu.net","user"=>"info@giaiphaptoiuu.net","password"=>"H0eq8fIC","from"=>"http://baomy.giaiphapthongminh.net");
$next1           ="<b>&nbsp;&rsaquo;&nbsp;</b>";
$next2           ="<b>&nbsp;&rsaquo;&rsaquo;&nbsp;</b>";

$arrayMale       =array("male" => "Male","female" => "Female");

define("prefixTable","");
define("HOST","http://".$_SERVER["HTTP_HOST"]."/");
/*
*******************************************************************************************************/

$URL_GOC = explode(".html",$_SERVER["REQUEST_URI"]);
if(count($URL_GOC)>0)
{
   $URL=explode("/",$URL_GOC[0]);
}else
{
  $URL=explode("/",$_SERVER["REQUEST_URI"]);
}
array_shift($URL);
$page=strtolower($URL[0]);
if($page=='')
{
 $page='home';
}
if(empty($page)) $page="home";
?>