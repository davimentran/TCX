function showtextalert() {
  alert("Vui lòng chọn danh mục cha cần thêm");
}

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
  		alert("Select the line you want to edit...");return false;
  	}
}
function multiInsert(pageCurrent,array_object)
{
    var ok=false;
    var num=prompt("Want to add line numbers...",2);
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
function duplicateCommon(pageCurrent,array_object){
    var ok=false;
    if(document.getElementById(array_object).value!="") ok=true;
    if(ok)
    {
        if(confirm('Double the current implementation?'))
    	{
            if(confirm('You always want to copy all the subfolders in each line are not?'))
    	    document.frm.action=pageCurrent+"&duplicate&recursive";
            else document.frm.action=pageCurrent+"&duplicate&norecursive";
    	    document.frm.submit();
    	}
    }else
  	{
  		alert("You need to double line coChon...");return false;
  	}
}
function deleteCommon(pageCurrent){
    var ok=false;
    var array_id=document.frm.arrayid.value;
    if(array_id.length>0) ok=true;
    if(ok){
    		if(confirm('Xác nhận xóa?'))
    		{
    			document.frm.action=pageCurrent+"&delete";
    			document.frm.submit();
    		}
  	}else
  	{
  		alert("Vui lòng chọn dòng muốn xoá...");return false;
  	}
}
function updateCommon(pageCurrent,parent){
   var array_id=document.frm.arrayid.value;
   if(array_id.length>0)
   {
    if(confirm('Update list?'))
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
function updateCategory(object,array_id){
	window.location = $.query.set(object.name,object.value );
}

function updateProducts(productid){
    document.frm.action="mngOptionProducts.php?productid="+productid;
   document.frm.submit();
}

function list_sortable(field){
	var current_list_sortable_field = $.query.get('list_sortable_field');
	var current_list_sortable_direction = $.query.get('list_sortable_direction');

	if(!current_list_sortable_field){
		new_list_sortable_direction = 'ASC';
	}else{		
		if(field != current_list_sortable_field){
			new_list_sortable_direction = 'ASC';
		}else{
			if(current_list_sortable_direction=='DESC'){
				new_list_sortable_direction = 'ASC';	
			}else{
				new_list_sortable_direction = 'DESC';
			}
		}
	}
	
	window.location = $.query.set('list_sortable_field',field).set('list_sortable_direction',new_list_sortable_direction);
};


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
function docheck(status,from_)
{
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
function nhapso(evt,objectid){

		var key=(!window.ActiveXObject)?evt.which:window.event.keyCode;
		var values=document.getElementById(objectid).value;
        //alert(key);
       /* if((key<48 || key >57) && (key!=8 || key!=46 || key!=0)) return false;*/
       if((key<48 || key >57) && key!=8 && key!=0 && key!=46 ) return false;


		return true;
}

function showPath(object,chkobject){
	if(object){
	    document.getElementById(chkobject).style.display='';
		document.getElementById(chkobject).focus();
	}else{document.getElementById(chkobject).style.display='none';}
}
function closePath(object,chkobject){object.style.display='none';var obj=eval("document.frm."+chkobject);obj.checked=false;
}
function fo(object){object.style.backgroundColor='#EBF1F6';object.select();object.style.borderColor="#D9B268"}
function lo(object){object.style.backgroundColor='#ffffff';object.style.borderColor="#CCCCCC"}
function modelessDialogShow(url,width,height){
    openBox(url,width,height);
}
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
function openBox(fileSrc,winWidth,winHeight) {
    if(winWidth=="") winWidth=screen.availWidth;
    if(winHeight=="") winHeight=screen.availHeight;
    if(winWidth=="auto") winWidth=screen.availWidth-50;
    if(winHeight=="auto") winHeight=screen.availHeight-100;
	var w=(screen.availWidth-winWidth)/2;var h=(screen.availHeight-winHeight)/2;

	newParameter = "width=" + winWidth + ",height=" + winHeight + ",addressbar=no,scrollbars=yes,toolbar=no,top="+h+",left="+w+", resizable=no";
    newWindow = window.open (fileSrc, "a", newParameter);
	newWindow.focus();
}
function showControl(checked)
{
    if(checked) document.getElementById("groupPassword").style.display='';
    else document.getElementById("groupPassword").style.display='none';
}