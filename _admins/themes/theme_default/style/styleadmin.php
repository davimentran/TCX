<?php
  if ( extension_loaded('zlib') and !ini_get('zlib.output_compression') and ini_get('output_handler') != 'ob_gzhandler' and ((version_compare(phpversion(), '5.0', '>=') and ob_get_length() == false) or ob_get_length() === false) ) {
          ob_start('ob_gzhandler');
  }
  header("Cache-Control: public");
  header("Pragma: cache");
  $offset = 5184000; // 60 * 60 * 24 * 60
  $ExpStr = "Expires: ".gmdate("D, d M Y H:i:s", time() + $offset)." GMT";
  $LmStr = "Last-Modified: ".gmdate("D, d M Y H:i:s", filemtime($_SERVER['SCRIPT_FILENAME']))." GMT";
  header($ExpStr);
  header($LmStr);
  header('Content-Type: text/css; charset: UTF-8');
?>
form{border-bottom:10px solid #5e8cbd;overflow:hidden;margin:0px auto;width:95%;border-top:1px solid #fff;overflow:hidden}
html,body{background:#fff;color:#333;font:11px verdana !important;margin:0px 0px 0px 0px;text-align:center}
.divSwap{width:100%;margin: 5px 0px 10px 0px}
div.standby{width:700px;margin:0 auto;position:relative;top:200px;text-align:center}
p.standby, h3.standby{font-size:18px;color:#ccc;text-transform:uppercase;line-height:150%}
td,p{font:11px/140% verdana;vertical-align:bottom;text-align:left}
textarea{border:1px solid #bbb;color:#333;font:13px verdana;height:80px;width:350px;padding-left:4px}
.boxGrey{background:#f0f0f0;border-bottom:1px solid #e0e0e0;border-left:1px solid #eee;border-right:1px solid #eee;border-top:1px solid #eee;color:#333;font:12px verdana;height:25px;padding:1px;padding-left:0px;text-align:left;text-indent:15px;width:15%}
.boxGrey2{background:#f0f0f0;border-bottom:1px solid #e0e0e0;border-left:1px solid #eeeeee;border-right:1px solid #eee;border-top:1px solid #eeeeee;color:#333;font:12px verdana;height:25px;padding:1px;padding-left:1px;text-align:left}
.boxGrey3{background:#f0f0f0;border-bottom:1px solid #e0e0e0;border-left:1px solid #eee;border-right:1px solid #eee;border-top:1px solid #eee;color:#333;font:12px verdana;height:25px;padding:1px;padding-left:20px;text-align:left}
.boxGreys{background:#f0f0f0;border-bottom:1px solid #e0e0e0;border-left:1px solid #eee;border-right:1px solid #eee;border-top:1px solid #eee;color:#333;font:12px verdana;height:25px;padding:1px;padding-left:20px;text-align:left;width:22%}
.boxTableView{border-left:1px solid #d0d0d0;border-top:1px solid #d0d0d0;margin-top:2px}
.btncenter{background:url(../images/XPButnBG.gif) repeat-x;border:medium none;color:#036;cursor:pointer;font-size:13px;height:21px;padding-left:4px;padding-right:4px;width:80px !important}
.btnleft{background:url(../images/XPButnBGLeft.gif) no-repeat;font-size:3px;height:21px;width:4px}
.btnright{background:url(../images/XPButnBGRight.gif) no-repeat;font-size:3px;height:21px;width:4px}
.bullet{margin-bottom:3px;margin-right:10px}
.cbo{border:1px solid #bbb;color:#333;font:13px verdana;width:350px}
.cell1{background:#EEE;border-bottom:1px solid #eee;border-left:1px solid #fefefe;border-right:1px solid #eee;border-top:0px solid #eee;color:#333;font:12px verdana;padding-left:0px}
.cell2{background:#FAFCFE;border-bottom:1px solid #e0e0e0;border-left:1px solid #fefefe;border-right:1px solid #fefefe;border-top:0px solid #eee;color:#333;font:12px verdana;padding-left:0px}
.cellAction{background:#f9f9f9;border-bottom:0px solid #eee;border-left:0px solid #fefefe;border-right:1px solid #d9d9d9;border-top:0px solid #eee;color:#333;font:12px verdana;padding-left:2px;padding-right:10px;text-align:left;width:70px}
.cellAction1{background:#f9f9f9;border:0px solid;padding-left:7px}
.cellAction11{background:#f9f9f9;border-bottom:0px solid #eee;border-left:0px solid #fefefe;border-right:0px solid #ccc;border-top:0px solid #eee;color:#333;font:12px verdana;padding-left:2px;padding-right:10px;text-align:left;width:70px}
.cellAction2{border:0px solid;padding-left:0px;padding-top:2px;vertical-align:bottom}
.cellmenu{border-right:1px solid #ccc;float:left;text-align:center;height: 29px}
.checkAll{margin-left:12px}
.checkDelete{margin-left:20px}
.corner{background:url(../images/cornerRight.gif) no-repeat;width:16px}
.font_hong{color:#333;font:normal 11px verdana;outline:none}
.header{background:url(../images/topnav-bg-dev.png) 0px 0px repeat-x}
.inlinecell{height: 20px !important;overflow:hidden;padding-left:10px;padding-top:5px;width:100%}
.inlinecellPos{height: 20px !important;margin:0 auto;padding-top:5px;text-align:center !important;width:8px}
.keyData{color:#FF5003;font-size:12px;text-decoration:none}
.menu{background:url(../images/title.jpg) left top repeat;border:0px solid;height:29px}
.nd{border:1px solid #bbb;color:#333;font:13px verdana;text-indent:4px;width:90px}
.nd1{border:1px solid #bbb;color:#333;font:13px verdana;text-indent:4px;width:300px}
.nd2{border:1px solid #bbb;color:#333;font:13px verdana;text-indent:4px;width:350px}
.nd3{border:1px solid #bbb;color:#333;font:13px verdana;text-indent:4px;width:450px}
.panelForm{width:100%}
.panelTable{background:#f9f9f9;border:0px;text-align:right}
.panelView{background:#fff;margin:0 auto;overflow:hidden;text-align:left;width:100%}
.titleAdmin{background:url(../images/admin.jpg) 15px 15px no-repeat;color:#fff;height:69px;padding-right:20px;text-align:right;vertical-align:middle}
.titleBottom{background:#5E8CBD;border-bottom:0px solid #fff;border-left:0px solid #e0e0e0;border-right:1px solid #ccc;border-top:0px solid #fff;color:#fff;font-size:11px;font-weight:bold;height:24px;padding:1px;padding-left:9px;text-align:left}
.transMenu{left:-1000px;overflow:hidden;position:absolute;top:-1000px}
.transMenu .background{filter: alpha(opacity=80);left:0px;opacity:0.8;position:absolute;top:0px;z-index:1}
.transMenu .content{font-size:11px;position:absolute}
.transMenu .item{border:none;color:#fff;cursor:pointer;font:12px tahoma;text-align:left;text-decoration:none}
.transMenu .item.hover {color:#ff0000;background-color:#eee;font-size:12px;font-family:verdana}
.transMenu .item img{margin-left:0px}
.transMenu .items{left:0px;position:relative;text-align:left;top:0px;z-index:1000}
.transMenu .shadowBottom{filter: alpha(opacity=30);height:2px;left:3px;opacity:0.3;position:absolute;z-index:1}
.transMenu .shadowRight{filter: alpha(opacity=30);opacity:0.3;position:absolute;top:3px;width:2px;z-index:3}
.transMenu .top .items{border-top:none;font-size:11px}
.txtdo{background:#eee;color:#c00;font:11px verdana}
.saodo{background:#f0f0f0;color:#c00;font:11px verdana;padding: 0px 5px 0px 5px;font-weight:bold}
td.boxRed,td.boxRedInside{background:#4f81b3 url(../images/star_blue.jpg) 6px 0px no-repeat;height:27px;}
div.boxRed,div.boxRedInside{color:#fff;font:bold 11px verdana;text-align:left;width:100%;text-indent:45px;text-transform:uppercase;height:19px}
div.panelAction{background:#f9f9f9;border:1px solid #CBD9E7;height:22px;margin:0 auto;overflow:hidden;margin-top:1px;margin-bottom:1px;text-align:left}
div.panelAction2{background:#f9f9f9;border:1px solid #CBD9E7;margin:0 auto;margin-top:1px;overflow:hidden;text-align:left}
div.panelActionContent{background:#f9f9f9;border:0px solid;float:right;margin-right:0px;text-align:right;width:270px}
div.panelActionContent2{background:#f9f9f9;border:0px solid;float:right;margin-right:0px;text-align:right}
table.spaw2liteframe{border:1px solid #d9d9d9;}
#box{border:0px solid;float:left;height:135px;margin-bottom:5px;overflow:hidden;width:210px}
#boxBottom{background:url(../images/boxBottom.jpg) no-repeat;border:0px solid;float:left;height:20px;width:220px}
#boxMiddle{background:url(../images/boxMiddle.jpg) repeat-y;border:0px solid;float:left;height:65px;padding-top:0px;width:220px}
#boxTop{background:url(../images/boxTop.jpg) 0px 2px no-repeat;border:0px solid;color:#547EA9;float:left;font-size:11px;font-weight:bold;height:55px;overflow:hidden;padding-top:0px;position:relative;text-align:left;text-decoration:underline;text-indent:75px;width:220px}
#clear,.clear{clear:both}
#indexCenter{background:#fff;border:0px solid;border-top:3px double #bbb;margin:0 auto;text-align:left;width:95%}
#indexTable{background:#fff;border:1px solid #B0C5D9;border-bottom:5px solid #658CB4;width:100%}
#mainTable{width:100%}
#space10{padding-left:10px;padding-right:10px}
#subtiennghi{background:#fff;float:left;font-size:12px;font-weight:bold;margin-bottom:2px;margin-left:1px;padding:0px 0 0px 0px;width:100%}
#subtiennghi2div{border:0px solid #999;float:left;margin:2px;width:24%}
#subtiennghiLeft{float:left;width:22px}
#subtiennghiRight{float:left;font-weight:normal;width:190px}
#tiennghi{background:#eee;border:0px solid;float:left;font-size:12px;font-weight:bold;height:20px;margin-bottom:2px;padding:5px 0 0px 8px;width:100%}
#top10{padding-bottom:10px;padding-left:10px;padding-top:10px}
#top5{padding-bottom:5px;padding-left:5px;padding-top:5px}
#topcenter{background:url(../images/topcenter.jpg) 0px 0px repeat-x;font-size:1px;height:15px;vertical-align:top}
#topleft{background:url(../images/topleft.jpg) 0px 0px no-repeat;float:left;font-size:3px;height:10px;width:15px}
#topright{background:url(../images/topright.jpg) 0px 0px no-repeat;float:right;font-size:3px;height:10px;width:15px}
div#insert,div#update{float:left}
div#item{background:url(../images/tick2.jpg) 30px 5px no-repeat;border:0px solid;float:left;padding-bottom:2px;padding-top:3px;text-align:left;width:220px}
a#item:link,a#item:visited{border:0px solid;color:#547EA9;float:left;font-weight:normal;padding-left:60px;text-decoration:underline;width:210px}
a#item:hover{color:#f60;float:left;font-weight:normal;padding-left:60px;text-decoration:none;width:210px}
a#itemText:link,a#itemText:visited{color:#547EA9;float:left;font-size:11px;font-weight:normal;text-decoration:none}
a#itemText:hover{color:#f60;float:left;font-size:11px;font-weight:normal;text-decoration:underline}
a#lnkaction:link,a#lnkaction:visited{color:#547EA9;float:left;font-weight:normal;text-decoration:underline}
a#lnkaction:hover{color:#f60;float:left;font-weight:normal;text-decoration:none}
a#welcome:link,a#welcome:visited{color:#f80;font:normal 12px verdana;outline:none;text-decoration:none}
a#welcome:hover{color:#f60;font:normal 12px verdana;outline:none;text-decoration:underline}
a.font_title:link,a.font_title:visited,a.font_title:hover {color:#f00;font:normal 11px verdana;outline:none}
a.home:link,a.home:visited{color:#fff;font:normal 11px verdana;text-decoration:none}
a.home:hover{color:#c00;font:normal 11px verdana;text-decoration:none}
a.top_menu:link,a.top_menu:visited,a.top_menu:active{color:#000;float:left;padding:8px 10px 0px 10px;height:21px}
a.top_menu:hover,a.top_menu_select:link,a.top_menu_select:visited,a.top_menu_select:hover{background:#e3e3e3;color:#c00;float:left;padding:8px 10px 0px 10px;height:21px}
a:link,a:visited{color:#3f5f7f;font:normal 11px verdana;outline:none;text-decoration:none}
a:hover{color:#f60;font:normal 11px verdana;outline:none;text-decoration:none}
div.paging_meneame{float:left;position:relative;margin-left:20px;margin-right:30px;}
div.paging_meneame a{float:left;border:#3f5f7f 1px solid;color:#333;margin:1px;padding: 0px 5px 0px 5px}
div.paging_meneame span.paging_current{float:left;background:#547EA9;border:#3f5f7f 1px solid;color:#fff;margin:1px;padding: 0px 5px 0px 5px}
div.paging_meneame span.paging_disabled{float:left;border:#d0d0d0 1px solid;color:#d0d0d0;margin:1px;padding: 0px 5px 0px 5px}
div.paging_meneame a:hover{float:left;background:#547EA9 none;border:#3f5f7f 1px solid;color:#fff;margin:1px;padding: 0px 5px 0px 5px}
.record{background-color:#5e8cbd;color:#fff;font-size:13px;font-weight:bold;padding-left:15px}
