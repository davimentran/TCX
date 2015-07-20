<?php

  define("hostmail","");
  define("usermail","");
  define("passwordmail","");
/* Section of paging
*************************************************************/
 $PageSize=15;
 $PageNo=((isset($_GET['PageNo']))?(int)$_GET['PageNo']:0);
 $Pagenumber=5;
 $ModePaging="Full";

/* Status of button: insert, update, delete, view
************************************************************/
 $isEdit=(isset($_GET['edit'])||isset($_GET['multiEdit']))?true:false;
 $isInsert=(isset($_GET['insert'])||isset($_GET['multiInsert']))?true:false;
 $isDelete=(isset($_GET['delete']))?true:false;
 $isView=(!$isEdit && !$isInsert && !$isDelete)?true:false;
 $subInsert=(isset($_POST["subinsert"]))?true:false;
 $subUpdate=(isset($_POST["subupdate"]))?true:false;
 $subUpdateCat=(isset($_GET['update']))?true:false;
 $disabledControl=(isset($_GET['edit']))?" disabled='disabled' ":"";
 $showControl=(isset($_GET['edit']))?"display:''":"display:none";
 $hideControl=(isset($_GET['edit']))?"display:none":"display:''";

 $URL_page=explode("/",$_SERVER["REQUEST_URI"]);
 array_shift($URL_page);
 $pageAdmin=strtolower($URL_page[1])."?";

/* Status of url query string
************************************************************/

 $QUERY_STRING=$_SERVER['QUERY_STRING'];
 $QUERY_STRING=preg_replace("/((norecursive|insert|delete|edit|multiEdit|multiInsert|view|update|duplicate)=?[0-9]*)/","",$QUERY_STRING);
 $QUERY_STRING=preg_replace("/((norecursive|insert|delete|edit|multiEdit|multiInsert|view|update|duplicate)=?[0-9]?)/","",$QUERY_STRING);
 $QUERY_STRING=preg_replace("/&{2,10}/","&",$QUERY_STRING);
 $QUERY_STRING=preg_replace("/^&/","",$QUERY_STRING);
 $QUERY_STRING=preg_replace("/&$/","",$QUERY_STRING);

 $PHP_SELF=$_SERVER['PHP_SELF'];
 $CURRENT_PAGE=array_pop(explode("/",$PHP_SELF));

/*
*************************************************************/
 define("pathTheme","themes/theme_default");
 define("CURRENCY","");
 define("CONFIRM","Confirm");
 define("INSERT","Insert");
 define("UPDATE","Update");
 define("HUY","Back");
 define("RESET","Reset");
 define("DEBUG_MODE",true);
 define("VAT","%");
 define("HOST","http://".$_SERVER["SERVER_NAME"]);
 define("QUERY_STRING",$QUERY_STRING);
 define("prefixTable","");
 define("DEBUG_MODE",true);
 define("UPDATED","Đã Update ({num}) dòng trong cơ sở dữ liệu");
 define("INSERTED","Đã thêm ({num}) dòng trong cơ sở dữ liệu");
 define("DELETED","Đã Delete ({num}) dòng trong cơ sở dữ liệu");
 define("ERROR_EXCEPTION","Throw new Exception");
 define("DATA_EXIST","Đã tồn tại mục dữ liệu này.");
 define("ADMINISTRATOR_FOLDER","_admins");
 define("queryParameter",$pageAdmin."?".QUERY_STRING);



/* Check status to picture
*************************************************************/

 $statusAction=array("1"=>"<img style='' src='".pathTheme."/images/b_approved.gif' border='0'>","0"=>"<img style='' src='".pathTheme."/images/b_delete.gif' border='0' />");

 $statusActive=array("1"=>'<input name="" type="checkbox" disabled value="" checked />',"0"=>'<input name="" type="checkbox" disabled value="" />');

 $statusChecked=array("1"=>"checked='checked'","0"=>"");

/* Define consts: Path editor, pictures: insert,update,delete,view
**************************************************************/

 define("defaultPicture","/products/imagehere.png");
 define("Editor","uploadfiladmin/assetmanager.php?");

 //define("insertIMG","<a title='Thêm'  href='?".QUERY_STRING."&insert'><img  src='".pathTheme."/images/new.jpg' border='0' title='Thêm' /></a>");
 //define("insertText","<a title='Thêm' id='lnkaction' href='?".QUERY_STRING."&insert'>Thêm</a>");

 define("insertIMG","<a title='Insert'  href='?".QUERY_STRING."&insert'><img  src='".pathTheme."/images/new.jpg' border='0' title='Insert' /></a>");
 define("insertText","<a title='Insert' id='lnkaction' href='?".QUERY_STRING."&insert'>Insert</a>");

 define("insertText2","<a title='Insert' onClick='showtextalert()' id='lnkaction' href='javascript:void(0)'>Insert</a>");

 define("insertmultiIMG","<a title='Thêm nhiều mẫu tin'  href='#' onclick=\"return multiInsert('?".QUERY_STRING."','arrayid')\" ><img  src='".pathTheme."/images/insert.jpg' border='0' title='Thêm nâng cao' /></a>");
 define("insertmultiText","<a title='Thêm nhiều mẫu tin' id='lnkaction' onclick=\"return multiInsert('?".QUERY_STRING."','arrayid')\" href='#'>Thêm nhiều</a>");

 define("editIMG","<a title='Sửa mẫu tin' href='#' onclick=\"return multiEdit('?".QUERY_STRING."','arrayid');\"><img  src='".pathTheme."/images/edit.jpg' border='0' title='Sửa nâng cao' /></a>");
 define("editText","<a title='Sửa mẫu tin' id='lnkaction' onclick=\"return multiEdit('?".QUERY_STRING."','arrayid');\" href='#'>Sửa nhiều</a>");

 define("selectIMG","<a title='Chọn tin' href='javascript:void(0);' onclick=\"docheck(!document.frm.chkall.checked,2);\"><img  src='".pathTheme."/images/check.jpg' border='0' title='Thêm' /></a>");
 define("selectText","<a title='Chọn tin' id='lnkaction' onclick=\"docheck(!document.frm.chkall.checked,2);\" href='javascript:void(0);'>Select</a>");

 define("deleteIMG","<a title='Delete' href='javascript:void(0);' onclick=\"return deleteCommon('?".QUERY_STRING."');\" ><img  src='".pathTheme."/images/b_delete.gif' border='0' title='Delete' /></a>");
 define("deleteText","<a title='Delete' id='lnkaction' href='javascript:void(0);' onclick=\"return deleteCommon('?".QUERY_STRING."');\">Delete</a>");

 define("duplicateIMG","<a href='javascript:void(0);' onclick=\"return duplicateCommon('?".QUERY_STRING."','arrayid');\" ><img  src='".pathTheme."/images/nhandoi.jpg' border='0' title='Nhân đôi' /></a>");
 define("duplicateText","<a id='lnkaction' href='javascript:void(0);' onclick=\"return duplicateCommon('?".QUERY_STRING."','arrayid');\">Nhân đôi</a>");

 define("viewIMG","<a href='?".QUERY_STRING."'><img  src='".pathTheme."/images/view.jpg' border='0' title='Xem' /></a>");
 define("viewText","<a id='lnkaction' href='?".QUERY_STRING."'>Làm mới</a>");

 define("backupIMG","<a href='#' onclick=\"openBox('backup.php','auto','400')\"><img  src='".pathTheme."/images/bakup.jpg' border='0' title='Sao lưu' /></a>");
 define("bakupText","<a id='lnkaction' onclick=\"openBox('backup.php','auto','400')\" href='#'>Sao lưu</a>");

 define("restoreIMG","<a href='#' onclick=\"openBox('restore.php','auto','200')\"><img  src='".pathTheme."/images/restore.jpg' border='0' title='Phục hồi' /></a>");
 define("restoreText","<a id='lnkaction' onclick=\"openBox('restore.php','auto','200')\" href='#'>Phục hồi</a>");

 define("truncateIMG","<a href='#' onclick=\"openBox('truncate.php?tbl={param}','auto','400')\"><img  src='".pathTheme."/images/b_delete.gif' border='0' title='Truncate bảng, xóa hết dữ liệu của bảng' /></a>");
 define("truncateText","<a id='lnkaction' onclick=\"openBox('truncate.php?tbl={param}','auto','400')\" href='#'>Xóa bảng</a>");

/* Define Enum array
******************************************************************/

 $arrayType=array("footer"=>"Footer","keywords"=>"Keywords","title"=>"Title","address"=>"Address",
                "description"=>"Description","copyright"=>"Copyright");

 $arrayExt=array(".sql");
 $arrayUpload=array("path"=>"tmp/");
 $arrayErrorFile=array("2"=>"File upload không thành công","3"=>"File không đúng định dạng .sql",
                        "4"=>"Kích thước file quá lớn");
global $arrayLog;
$arrayLog=array();

 $arrayAction=array("select"=>"Xem","insert"=>"Thêm","delete"=>"Xóa","update"=>"Update");
 $arrayUnit=array("trieudong"=>"Triệu đồng","tydong"=>"Tỷ đồng","usd"=>"USD");
 $arrayField=array();

 $arrayHeader=array("utf8"=>"utf-8","refresh"=>"3600",
                    "title"=>"..:: Administrator ::..",
                    "icon"=>"images/favicon.ico",
                    "keywords"=>"Administrator","description"=>"","copyright"=>"");
?>