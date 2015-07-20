<style type="text/css">
/*<![CDATA[*/
  .right_row1
  {

  }
  .right_row2 {
     color: #0000CC;
     font-weight: bold;
  }
  .clear
  {
    width: 100%;
    border-bottom: 1px dotted #ccc;
  }


/*]]>*/
</style>
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
<?php include("linkmember.php");?>
<div style="clear: both"></div>
<form action="/register/<?php echo md5("edit".date("dmYH"))?>" method="post" class="jNice" name="frminfo" id="frminfo">

<div class='title_header'>THÔNG TIN TÀI KHOẢN</div>
<div class="pro_c">
<fieldset style="border: 1px solid #999; padding: 5px;">
    <legend><b>Thông tin tài khoản</b></legend>

<div class="saodo"><h3 style="padding-left:10px;color:#c00;font-size:12px;margin:0px"><?php echo $msg2?></h3></div>

<div class="clear" style="padding-top:10px"></div>

<div class="clear"></div>
<div class="right_row1">Mã ID</div>
<div class="right_row2">
  <?php echo $info["MS"].$rowgetInfo->id; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Tên đăng nhập</div>
<div class="right_row2">
  <?php echo $rowgetInfo->tendangnhap; ?>
</div>
<div class="clear"></div>
<div class="right_row1">E-mail</div>
<div class="right_row2">
  <?php echo $rowgetInfo->email; ?>
</div>
<!--Email-->

<div class="clear"></div>
<div class="right_row1">Người bảo trợ</div>
<div class="right_row2">
  <?php echo $infonguoibaotro["hovaten"]; ?>
</div>

</fieldset>
<div class="clear" style="padding-top:10px; border: 0px"></div>
<fieldset style="border: 1px solid #999; padding: 5px;">
<legend>
   <b>Thông tin chung</b>
</legend>
<div class="clear" style="padding-top:10px"></div>
<div class="right_row1">Họ và Tên</div>
<div class="right_row2">
  <?php echo $rowgetInfo->hovaten; ?>
</div>
<div class="clear"></div>
<div class="right_row1">Ngày sinh</div>
<div class="right_row2">
  <?php echo date("d-m-Y",$rowgetInfo->date_ngaysinh); ?>
</div>

<div class="clear"></div>
<div class="right_row1">Giới tính</div>
<div class="right_row2">
  <?php echo $rowgetInfo->gioitinh; ?>
</div>

<div class="clear"></div>
<div class="right_row1">CMND</div>
<div class="right_row2">
  <?php echo $rowgetInfo->cmnd; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Ngày cấp</div>
<div class="right_row2">
  <?php echo date("d-m-Y",$rowgetInfo->date_ngaycap); ?>
</div>

<div class="clear"></div>
<div class="right_row1">Nơi cấp</div>
<div class="right_row2">
  <?php echo $rowgetInfo->noicap; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Địa chỉ</div>
<div class="right_row2">
  <?php echo $rowgetInfo->diachi; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Xã/Phường</div>
<div class="right_row2">
   <?php echo $rowgetInfo->xaphuong; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Quận/Huyện</div>
<div class="right_row2">
  <?php echo $rowgetInfo->quanhuyen; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Tỉnh/Thành Phố</div>
<div class="right_row2">
<?php
     echo $infotinhthanh['title'];
?>
</div>

<div class="clear"></div>
<div class="right_row1">Số điện thoại</div>
<div class="right_row2">
   <?php echo $rowgetInfo->didong; ?>
</div>
</fieldset>

<div class="clear" style="padding-top:10px; border: 0px"></div>
<fieldset style="border: 1px solid #999; padding: 5px;">
<legend><b>Thông tin thanh toán</b></legend>
<div class="clear" style="padding-top:10px"></div>

<div class="clear"></div>
<div class="right_row1">Tên chủ tài khoản</div>
<div class="right_row2">
   <?php echo $rowgetInfo->tenchutaikhoan; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Số tài khoản</div>
<div class="right_row2">
    <?php echo $rowgetInfo->sotaikhoan; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Ngân hàng</div>
<div class="right_row2">
    <?php echo $rowgetInfo->nganhang; ?>
</div>

<div class="clear"></div>
<div class="right_row1">Chi nhánh</div>
<div class="right_row2">
    <?php echo $rowgetInfo->chinhanh; ?>
</div>

</fieldset>
<div class="clear" style="padding-top:8px; border: 0px"></div>

<div class="right_row2">
    <input type="submit" value="Chỉnh sửa thông tin" name="cmdeditaccout" />
</div>
</div>
<div class="clear" style="padding-top:8px; border: 0px;"></div>
</form>
<?php
}
?>

</div>
