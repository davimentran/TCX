<?php include("index_table.php");?>
<div align="center">
<div id="indexCenter" align="center">
  <table cellpadding="0" cellspacing="0" id="indexTable">
    
    <?php
        echo $dbf->returnTitleMenu("Welcome to Administrator");
    ?>
    <tr>
    <td align="center" valign="top">
        <div style="padding-top: 10px;float:left;margin-left:15px; min-height: 400px;">
        <?php
            $dbf->showIndex();
         ?>
            <div id="clear"></div>
        </div>
    </td>
    </tr>
    <tr><td style="height:5px;"></td></tr>
  </table>
</div>
</div>