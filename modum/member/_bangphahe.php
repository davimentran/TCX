    <link rel="stylesheet" href="style/jquery.treeview.css" />
	<script src="js/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="js/jquery.treeview.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/script_function.js"></script>
<div class="post block">
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
<div class="clear"></div>

  <div class="accordion-group">
     <div style="background: #2D82C3; color: white; font-size:20px; padding:10px;cursor: Pointer; text-transform: uppercase; text-align:center; font-weight:bold" class="accordion-toggle">
      DANH SÁCH Thành Viên CỦA <?php echo $rowgetInfo->hovaten; ?>
      </div>
  </div>
  <div style="padding: 0px 20px;">
   <ul id="navigation" class="ul_<?php echo $rowgetInfo->id?>">
		<li id="<?php echo $rowgetInfo->id?>">
            <?php echo $rowgetInfo->hovaten; ?>
            <?php $dbf->getTreeMember($rowgetInfo->id,$info["MS"]); ?>
		</li>
	</ul>
    </div>

<?php } ?>
<div class="clear"></div>
</div>
