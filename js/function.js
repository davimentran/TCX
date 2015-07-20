function nhapso(evt,objectid){

		var key=(!window.ActiveXObject)?evt.which:window.event.keyCode;
		var values=document.getElementById(objectid).value;
        //alert(key);
       /* if((key<48 || key >57) && (key!=8 || key!=46 || key!=0)) return false;*/
       if((key<48 || key >57) && key!=8 && key!=0 && key!=46 ) return false;


		return true;
}