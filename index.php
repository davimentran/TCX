<?php
/********************************************/
session_start();
error_reporting(1);
include str_replace('\\','/',dirname(__FILE__)).'/class/defineConst.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.BUSINESSLOGIC.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.CSS.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.JAVASCRIPT.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.HTML.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.utilities.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.SINGLETON_MODEL.php';

$dbf  =SINGLETON_MODEL::getInstance("BUSINESSLOGIC");
$html =SINGLETON_MODEL::getInstance("HTML");
$css  =SINGLETON_MODEL::getInstance("CSS");
$js   =SINGLETON_MODEL::getInstance("JAVASCRIPT");
$utl  =SINGLETON_MODEL::getInstance("UTILITIES");

$html->docType();
$html->openHTML();
$html->openHead();
echo "<base href='". HOST."' />";

if(empty($_SESSION["login"])){
    $_SESSION["login"]=session_id();
    $_SESSION["Free"]=1;
}

if($URL[0]==md5("signout".date("dmH")))
    $dbf->signout();

$info = $dbf->getConfig();

?>
    <title><?php echo $info['title'];?></title>

<?php
    $html->metaEncoding("UTF-8");
    $html->description($info["DESCRIPTION"]);
    $html->keywords($info["KEYWORDS"]);
    $arrayCSS=array("style/style.css","_admins/css/ui.all.css");
    foreach($arrayCSS as $value) $css->linkCSS($value);

    $arrayJS=array("js/jquery.js","js/jquery.validate.pack.js","js/jquery.form.js","_admins/js/ui.datepicker.js","js/function.js");
    foreach($arrayJS as $value) $js->linkJS($value);

	$html->closeHead();
    $html->openBody(array());
    /* End header
    ********************************************/
?>
<div class='divSwrapper'>
    <div class="center_main">
        <?php
          include("modum/bodymain.php");
        ?>
    </div> <!--end center !-->
</div><!--end swapper-->

  <!--[if lt IE 7]>
<link type="text/css" rel="stylesheet" href="style/ie/ie6.css" />
<div id="overall"></div>
<div id="absolute">
	<DIV id=iecheck style="FILTER: ; VISIBILITY: visible; opacity: 1">
		<P class=msg>
			You are using Internet Explorer 6. Please upgrade your browser to increase safety and your browsing experience.
			<br />
			<div class="clear break-line"></div>
			<center>
			Choose one of the following links to download a modern browser:
			<br />
			<A href="http://www.getfirefox.com" target=_blank>
				<IMG title="Get Firefox" height=24 alt="Get Firefox" src="style/images/iecheck/firefox.png" border="0" width=25/>
				Firefox
			</A>
			<A class=safari href="http://www.apple.com/safari/download/" target=_blank>
				<IMG title="Get Safari" height=24 alt="Get Safari" src="style/images/iecheck/safari.png" border="0" width=25 />
				Safari
			</A>
			<A class=opera href="http://www.opera.com/download/" target=_blank>
				<IMG title="Get Opera" height=24 alt="Get Opera" src="style/images/iecheck/opera.png" border="0" width=25/>
				Opera
			</A>
			<A class=internetexplorer href="http://www.microsoft.com/windows/downloads/ie/getitnow.mspx" target=_blank>
				<IMG title="Get latest Internet Explorer" height=24 alt="Get latest Internet Explorer" border="0" src="style/images/iecheck/ie.png" width=25/>
				Internet Explorer
			</A>
			</center>
		</P>
		<div class="clear break-line"></div>
		<div class="clear break-line"></div>
	</DIV>
</div>
<![endif]-->

<?php
    $html->closeBody();
    $html->closeHTML();
?>