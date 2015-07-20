<?php
define("pathPicture","..");
define("subdomain","1");
/*
1: Neu khong phai la subdomain
0: Neu la subdomain
****************************************************************/
$bReturnAbsolute=false;
/*
Customize Products folder
****************************************************************/
$sName0="Products";
$Folder0="products";
$sBaseVirtual0='/'.$Folder0;
$sBase0=str_replace("\\","/",$_SERVER["DOCUMENT_ROOT"]."/".$Folder0); //The real path
/*
Customize Images folder
****************************************************************/
//$sName1="Asset";
//$Folder1="Asset";
//$sBaseVirtual1='/'.$Folder1;
//$sBase1=str_replace("\\","/",$_SERVER["DOCUMENT_ROOT"]."/".$Folder1); //The real path
?>