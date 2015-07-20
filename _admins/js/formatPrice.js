function fmtMoney(num) { num = num.toString().replace(/\$|\,/g,''); if(isNaN(num)) num = "0"; sign = (num == (num = Math.abs(num))); num = Math.floor(num*100+0.50000000001); cents = num%100; num = Math.floor(num/100).toString(); if(cents<10) cents = "0" + cents; for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) num = num.substring(0,num.length-(4*i+3))+'.'+ num.substring(num.length-(4*i+3)); return (((sign)?'':'-') + '' + num); }


function openBox(fileSrc,winWidth, winHeight) {
	var w=(screen.availWidth-winWidth)/2;
	var h=(screen.availHeight-winHeight)/2;
	newParameter = "addressbar=no,scrollbars=yes,toolbar=no,top=0,left=0,right=0,bottom=0,resizable=no";
    newWindow = window.open (fileSrc, "a", newParameter);
	newWindow.focus();
}
