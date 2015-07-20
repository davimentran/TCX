<div class="post block" style="padding: 20px">

<?php
if( $_SESSION["Free"]==1)
{
  $html->redirectURL("/login.html");

}else
{
        $rstgetInfo=$dbf->getDynamic("member","id='".$_SESSION["member_id"]."'","");
        $rowgetInfo=$dbf->nextObject($rstgetInfo);

        $infonguoibaotro = $dbf->getInfoColum("member",(int)$rowgetInfo->parentid);
        $infotinhthanh = $dbf->getInfoColum("city_vietnam",(int)$rowgetInfo->tinhthanh);


?>
<div style="float: left; padding:20px;">
<?php include("linkmember.php");?>
</div>
<div style="clear: both"></div>


<?php } ?>
<div class="clear"></div>
</div>
