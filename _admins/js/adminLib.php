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
  header('Content-Type: text/javascript; charset: UTF-8');
?>
function multiEdit(pageCurrent,array_object){
    var ok=false;
    var arrayid=document.getElementById(array_object).value;
    if(arrayid!="") ok=true;
    if(ok)
    {
        document.frm.action=pageCurrent+"&multiEdit";
    	document.frm.submit();
    }else
  	{
  		alert("Vui lòng chọn check vào các mục bạn muốn sửa !");return false;
  	}
}
/*
****************************************************/
var mytime=null;
var itime=0;
function standBy(id,minute)
{
  try
  {
      minute=parseInt(minute);
      if(itime>=minute)
      {
         document.getElementById(id).className="coverOpacity50";
         clearTimeout(mytime);
      }else
      {
        ++itime;
        setTimeout("standBy('"+id+"','"+minute+"')",1000);
      }
  }catch(e){
    clearTimeout(mytime);
  }
}
/*
****************************************************/
function stopStandby(id,minute)
{
  try
  {
      itime=0;
      mytime=null;
      document.getElementById(id).className="coverOpacity0";
      standBy(id,minute);
  }catch(e){
    clearTimeout(mytime);
  }
}
/*
****************************************************/
function multiInsert(pageCurrent,array_object)
{
    var ok=false;
    var num=prompt("Bạn muốn thềm bao nhiêu dòng?",2);
    num=parseInt(num);
    if(num>=2)
    {
        document.getElementById(array_object).value=num;
        document.frm.action=pageCurrent+"&multiInsert="+num;
    	document.frm.submit();
    }else if(num>=1)
    {
      window.location=pageCurrent+"&insert";
    }
    else return false;
}
/*
****************************************************/
function duplicateCommon(pageCurrent,array_object){
    var ok=false;
    if(document.getElementById(array_object).value!="") ok=true;
    if(ok)
    {
        if(confirm('Bạn có thật sự muốn nhân đôi những dòng được chọn không?'))
    	{
            if(confirm('Bạn có muốn copy luôn tất cả những mục con trong mỗi dòng không?'))
    	    document.frm.action=pageCurrent+"&duplicate&recursive";
            else document.frm.action=pageCurrent+"&duplicate&norecursive";
    	    document.frm.submit();
    	}
    }else
  	{
  		alert("Vui lòng chọn mục cần nhân  đôi!");return false;
  	}
}
/*
****************************************************/
function deleteCommon(pageCurrent){
    var ok=false;
    var array_id=document.frm.arrayid.value;
    if(array_id.length>0) ok=true;
    if(ok){
    		if(confirm('Bạn có thật sự muốn xóa những dòng bạn đã chọn?'))
    		{
    			document.frm.action=pageCurrent+"&delete";
    			document.frm.submit();
    		}
  	}else
  	{
  		alert("Vui lòng chọn mục cần xóa!");return false;
  	}
}
/*
****************************************************/
function updateCommon(pageCurrent,parent){
   var array_id=document.frm.arrayid.value;
   if(array_id.length>0)
   {
    if(confirm('Bạn có thật sự muốn cập nhật lại danh mục của những dòng bạn chọn không?'))
    {
        document.frm.action=pageCurrent+"&caturl="+parent+"&parentCat="+parent+"&update";
        document.frm.submit();
    }else
    {
        window.location=pageCurrent+"&caturl="+parent;
    }
   }else
   {
     window.location=pageCurrent+"&caturl="+parent;
   }
}
/*
****************************************************/
function getstring(){
      var str="";
      var alen=document.frm.chk.length;

      if (alen>1)
      {
      	for(var i=0;i<alen;i++)
      		if(document.frm.chk[i].checked==true) str+=document.frm.chk[i].value+",";
      }else
      {
      	if(document.frm.chk.checked==true) str=document.frm.chk.value;
      }

      document.frm.arrayid.value=str;
}
/*
****************************************************/
function docheck(status,from_){
		var alen=document.frm.chk.length;

		if (alen>1)
		{
			for(var i=0;i<alen;i++)
				document.frm.chk[i].checked=status;
		}else
		{
				document.frm.chk.checked=status;
		}
		if(from_>0)
			document.frm.chkall.checked=status;
		getstring();
}
/*
****************************************************/
function docheckone(){
var alen=document.frm.chk.length;
var isChecked=true;
if (alen>1)
{
	for(var i=0;i<alen;i++)
		if(document.frm.chk[i].checked==false)
			isChecked=false;
}else
{
	if(document.frm.chk.checked==false)
		isChecked=false;
}
document.frm.chkall.checked=isChecked;
getstring();
}
/*
****************************************************/
function nhapso(evt,objectid){
		var key=(!window.ActiveXObject)?evt.which:window.event.keyCode;	
		var values=document.getElementById(objectid).value;
		if(key==8)
		{
			if(values.length<=1)
			{
				document.getElementById(objectid).value="0";
				document.getElementById(objectid).select();
				return false;
			}
		}else if(key==46)
        {
            if(values.length<=1 || values=="")
			{
				document.getElementById(objectid).value="0";
				document.getElementById(objectid).select();
				return false;
			}
        }
        else
		{
			if((key<48 || key >57)) return false;
		}
		return true;
}
/*
****************************************************/
function init(){
	if (TransMenu.isSupported()){
			TransMenu.initialize();
		}
}
/*
****************************************************/
function startBlink(element)
{
  object=document.getElementById(element);
  if(object.style.display=="") object.style.display='none';
  else object.style.display="";
  mytime=setTimeout("startBlink('"+element+"')",1000);
}
/*
****************************************************/
function stopBlink(element)
{
  try
  {
  	clearTimeout(mytime);
  }catch(ex)
  {
  	mytime=null;
  	clearTimeout(mytime);
  }
}
/*
****************************************************/
function waiting()
{
    document.getElementById('divposition').style.display='';
    document.frmlogin.protectioncode.focus();
    document.getElementById('protectioncode').value='';
    document.getElementById('username').value='';
    document.getElementById('password').value='';
    document.frmlogin.protectioncode.disabled='';
}
/*
****************************************************/
function getposition(){
  document.all['divposition'].style.position='absolute';document.all['divposition'].style.width='50%';
  document.all['divposition'].style.left=screen.availWidth/2-275;document.all['divposition'].style.top=screen.availHeight/2-300;
  document.all['divposition'].style.display='';
}
/*
****************************************************/
function showPath(object,chkobject){
	if(object){
		document.getElementById(chkobject).style.display='';
		document.getElementById(chkobject).focus();
	}else{document.getElementById(chkobject).style.display='none';}
}
/*
****************************************************/
function closePath(object,chkobject){
    object.style.display='none';var obj=eval("document.frm."+chkobject);obj.checked=false;
}
/*
****************************************************/
function fo(object){object.style.backgroundColor='#f6f6f6';object.select();}
/*
****************************************************/
function lo(object){object.style.backgroundColor='#ffffff';}
/*
****************************************************/
function modelessDialogShow(url,width,height){
	if (document.all&&window.print) //if ie5
	eval('window.showModelessDialog(url,window,"dialogWidth:'+width+'px;dialogHeight:'+height+'px;edge:Raised;center:on;dialogLeft:280px; dialogTop:150px; help:off; resizable:on")');
	else
	openBox(url,width,height);	
}
/*
****************************************************/
function isEmail(s){
  if (s=="") return false;
  if(s.indexOf(" ")>0) return false;
  var i = 1;
  var sLength = s.length;
  if (s.indexOf(".")==sLength) return false;
  if (s.indexOf(".")<=0) return false;
  if (s.indexOf("@")!=s.lastIndexOf("@")) return false;

  while ((i < sLength) && (s.charAt(i) != "@"))
  { i++
  }

  if ((i >= sLength) || (s.charAt(i) != "@")) return false;
  else i += 2;
  while ((i < sLength) && (s.charAt(i) != "."))
  { i++
  }
  if ((i >= sLength - 1) || (s.charAt(i) != ".")) return false;
   var str="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghikjlmnopqrstuvwxyz-@._";
   for(var j=0;j<s.length;j++)
	if(str.indexOf(s.charAt(j))==-1) return false;
   return true;
}
/*
****************************************************/
function validTel(s){
	var str="0123456789)(- .";
	if(s.length>=20||s.length<=5) return false;
	for(var i=0;i<s.length;i++)
	{
		if(str.indexOf(s.charAt(i))==-1)	return false;
	}
	return true;
}
/*
****************************************************/
function showhide(thecell){
		if(theoldcell == thecell){
            document.getElementById(thecell).style.display='none';
            document.getElementById(theoldcell).style.display='none';
			theoldcell = "";
		}else{
			if(theoldcell != thecell){
				if(theoldcell != "")
                document.getElementById(theoldcell).style.display='none';
				document.getElementById(thecell).style.display='';
				theoldcell = thecell;
			}
		}
}
/*
****************************************************/
function flashWrite(url,w,h,id,bg,vars,win){
	var flashStr=
	"<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='"+w+"' height='"+h+"' id='"+id+"' align='middle'>"+
	"<param name='allowScriptAccess' value='always' />"+
	"<param name='movie' value='"+url+"' />"+
	"<param name='FlashVars' value='"+vars+"' />"+
	"<param name='wmode' value='"+win+"' />"+
	"<param name='menu' value='false' />"+
	"<param name='quality' value='high' />"+
	"<param name='bgcolor' value='"+bg+"' />"+
	"<embed src='"+url+"' FlashVars='"+vars+"' wmode='"+win+"' menu='false' quality='high' bgcolor='"+bg+"' width='"+w+"' height='"+h+"' name='"+id+"' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />"+
	"</object>";
	document.write(flashStr);
}
/*
****************************************************/
function openBox(fileSrc,winWidth,winHeight) {
	var w=(screen.availWidth-winWidth)/2;var h=(screen.availHeight-winHeight)/2;
	newParameter = "width=" + winWidth + ",height=" + winHeight + ",addressbar=no,scrollbars=yes,toolbar=no,top="+h+",left="+w+", resizable=no";
    newWindow = window.open (fileSrc, "a", newParameter);
	newWindow.focus();
}
function setAlpha(object,value)
{
    try
    {
        object.style.opacity=value;
    }catch(ex){return false;}
}
/*
****************************************************/
function showControl(checked)
{
    if(checked) document.getElementById("groupPassword").style.display='';
    else document.getElementById("groupPassword").style.display='none';
}
/*
****************************************************/
var xmlhttp=null;
function getXMLHTTP(){
    var xmlhttp=null;
    if(window.XMLHttpRequest)
    {
    	xmlhttp=new XMLHttpRequest();
    }else if(window.ActiveXObject)
    {
    	try
    	{
    		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    	}catch(e)
    	{
    		try
    		{
    			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    		}catch(e)
    		{
    			alert('This browser does not support');return;
    		}
    	}

    }else{
    	alert('This browser does not support!');return;
    }
    return xmlhttp;
}