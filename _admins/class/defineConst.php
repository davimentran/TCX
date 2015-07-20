<?php
/*
Section of paging
*********************************************************************************************************/
$PageSize=15;
$PageNo=$_GET['PageNo'];
$Pagenumber=10;
$ModePaging="Full";
/*Setting language
*******************************************************************************************************/
$arrayLang=array("vn"=>"vn","en"=>"en");
$arraySMTPSERVER=array("host"=>"","user"=>"","password"=>"","from"=>"");
define("prefixTable","");
define("HOST","http://".$_SERVER["HTTP_HOST"]."/");
/*
*******************************************************************************************************/

$URL=explode("/",$_SERVER["REQUEST_URI"]);
array_shift($URL);
$page=strtolower($URL[0]);

if(empty($page)) $page="trang-chu";

$_GET['component_function_alias'] = $page;
$lang=$URL[1];
if(empty($lang)) $lang="vn";

$t=count($URL);
$trr_lang="";
if($t==3){$trr_lang="/".$URL[2];}
else if($t==4){ $trr_lang="/".$URL[2]."/".$URL[3];}
else if($t==5){$trr_lang="/".$URL[2]."/".$URL[3]."/".$URL[4];}
//echo $trr_lang;

define("VN","/".$page."/vn".$trr_lang."");
define("EN","/".$page."/en".$trr_lang."");

?>