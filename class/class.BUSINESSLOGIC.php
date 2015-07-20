<?php
include str_replace('\\', '/', dirname(__FILE__)) . '/class.DBFUNCTION.php';
class BUSINESSLOGIC extends DBFUNCTION {
  /*******************************************************************/
   function price($price){
        $str = number_format($price,0,",",".");
        return $str;
   }

  function signout() {
      session_unset();
      session_destroy();
      $_SESSION["login"]=session_id();
      $_SESSION["Free"]=1;
      echo "<script type='text/javascript'>window.location='home.html';</script>";
  }
  /********************************************************************/
  function Button($idName, $arrayOption) {
    return "<table border='0' cellpadding='0' cellspacing='0' ALPHA8>
    					<tr><td class='btnleftSearch'></td>
						<td>" . $this->input($idName, $arrayOption) . "</td>
    					<td class='btnrightSearch'></td>
    			</tr>
    	</table>";
  }

  /*******************************************************************/
  function takeShortText($longText, $numWords) {
    $ret = "";
    if ($longText != "") {
      $longText = trim($longText);
      $longText = stripslashes($longText);
      $longText = strip_tags($longText);
      if (str_word_count($longText) > $numWords) {
        $arrayText = explode(" ", $longText);
        for ($i = 0; $i < $numWords; $i++) {
          $ret .= $arrayText[$i] . " ";
        }
        $ret = trim($ret) . "... ";
        return $ret;
      }
      else {
        return $longText;
      }
    }
  }

  function returnUser()
  {
  	if((!session_is_registered("login"))||($_SESSION['login']==""))
  	{
  		$_SESSION["login"]=session_id();
  	}else
  	{
  		return $_SESSION['login'];
  	}
  }

  function make_protect_image($image="",$font="",$protect="",$color="#000000",$size=15) {
        if(eregi("([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})", $color, $ca)) {
			$red = hexdec($ca[1]);
			$green = hexdec($ca[2]);
			$blue = hexdec($ca[3]);
        }
        $pass = "";
		$chars = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
		$count = count($chars) - 1;
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < 5; $i++)
			$pass .= $chars[rand(0, $count)];
		$img = imagecreatefromjpeg($image);
		$text_color = imagecolorallocate($img, $red, $green, $blue);
		$w = 10;
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < strlen($pass); $i++) {
			$a = rand(45, -45);
			$t = substr($pass, $i, 1);
			imagettftext($img,$size,$a,$w,30,$text_color,$font,$t);
			$w = $w + 15;
		}
		imagejpeg($img, $protect);
		@ imagedestroy($img);
		return ($pass);
	}

  /*
  Paging on one table
  *******************************************************************/
  function paging($tablename, $where, $orderby, $url, $PageNo, $PageSize, $Pagenumber, $ModePaging) {
    if ($PageNo == "") {
      $StartRow = 0;
      $PageNo = 1;
    }
    else
      $StartRow = ($PageNo - 1) * $PageSize;
    if ($PageSize < 1 || $PageSize > 50)
      $PageSize = 15;
    if ($PageNo % $Pagenumber == 0)
      $CounterStart = $PageNo - ($Pagenumber - 1);
    else
      $CounterStart = $PageNo - ($PageNo % $Pagenumber) + 1;
    $CounterEnd = $CounterStart + $Pagenumber;
    $TRecord = $this->getArray($tablename, $where, $orderby, "stdObject");
    $RecordCount = count($TRecord);
    $result = $this->getDynamic($tablename, $where, $orderby . " LIMIT " . $StartRow . "," . $PageSize);
    if ($RecordCount % $PageSize == 0)
      $MaxPage = $RecordCount / $PageSize;
    else
      $MaxPage = ceil($RecordCount / $PageSize);
    $gotopage = "";
    switch ($ModePaging) {
      case "Full" :
        $gotopage = '<div class="paging_meneame">';
        if ($MaxPage > 1) {
          if ($PageNo != 1) {
            $PrevStart = $PageNo - 1;
            $gotopage .= ' <a href="' . $url . '&PageNo=1" tile="First page"> &laquo; </a>';
            $gotopage .= ' <a href="' . $url . '&PageNo=' . $PrevStart . '" title="Previous page"> &lsaquo; </a>';
          }
          else {
            $gotopage .= ' <span class="paging_disabled"> &laquo; </span>';
            $gotopage .= ' <span class="paging_disabled"> &lsaquo; </span>';
          }
          $c = 0;
          for ($c = $CounterStart; $c < $CounterEnd;++$c) {
            if ($c <= $MaxPage)
              if ($c == $PageNo)
                $gotopage .= '<span class="paging_current"> ' . $c . ' </span>';
              else
                $gotopage .= ' <a href="' . $url . '&PageNo=' . $c . '" title="Page ' . $c . '"> ' . $c . ' </a>';
          }
          if ($PageNo < $MaxPage) {
            $NextPage = $PageNo + 1;
            $gotopage .= ' <a href="' . $url . '&PageNo=' . $NextPage . '" title="Next page"> &rsaquo; </a>';
          }
          else {
            $gotopage .= ' <span class="paging_disabled"> &rsaquo; </span>';
          }
          if ($PageNo < $MaxPage)
            $gotopage .= ' <a href="' . $url . '&PageNo=' . $MaxPage . '" title="Last page"> &raquo; </a>';
          else
            $gotopage .= ' <span class="paging_disabled"> &raquo; </span>';
        }
        $gotopage .= ' </div>';
        break;
    }
    $arr[0] = $result;
    $arr[1] = $gotopage;
    return $arr;
  }


  function getidCat($table,$value){
    $result=$this->getDynamic($table,"id=".$value,"");
       if($this->totalRows($result))
       {
         $row=$this->nextData($result);
         return $row["parentid"];
       }
  }

  function getInfoColum($table,$id){
      $result=$this->getDynamic($table,"id='".$id."'","");
       if($this->totalRows($result))
       {
         $row=$this->nextData($result);
         return $row;
       }
  }

  function getInfoColumShipping($table,$id){
      $result=$this->getDynamic($table,"member_id='".$id."'","");
       if($this->totalRows($result))
       {
         $row=$this->nextData($result);
         return $row;
       }
  }

  function checkIsCategory ($table,$id){
       $result=$this->getDynamic($table,"parentid='".$id."'","");
       if($this->totalRows($result)>0)
       {
         return 1;
       }else
       {
         return 0;
       }
  }


   function VndText($amount)
   {
         if($amount <=0)
        {
            return $textnumber="Tiền phải là số nguyên dương lớn hơn số 0";
        }
        $Text=array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua =array("","nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        $textnumber = "";
        $length = strlen($amount);

        for ($i = 0; $i < $length; $i++)
        $unread[$i] = 0;

        for ($i = 0; $i < $length; $i++)
        {
            $so = substr($amount, $length - $i -1 , 1);

            if ( ($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)){
                for ($j = $i+1 ; $j < $length ; $j ++)
                {
                    $so1 = substr($amount,$length - $j -1, 1);
                    if ($so1 != 0)
                        break;
                }

                if (intval(($j - $i )/3) > 0){
                    for ($k = $i ; $k <intval(($j-$i)/3)*3 + $i; $k++)
                        $unread[$k] =1;
                }
            }
        }

        for ($i = 0; $i < $length; $i++)
        {
            $so = substr($amount,$length - $i -1, 1);
            if ($unread[$i] ==1)
            continue;

            if ( ($i% 3 == 0) && ($i > 0))
            $textnumber = $TextLuythua[$i/3] ." ". $textnumber;

            if ($i % 3 == 2 )
            $textnumber = 'trăm ' . $textnumber;

            if ($i % 3 == 1)
            $textnumber = 'mươi ' . $textnumber;


            $textnumber = $Text[$so] ." ". $textnumber;
        }

        //Phai de cac ham replace theo dung thu tu nhu the nay
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

        return ucfirst($textnumber." đồng chẵn");
      }

      function AUDText($amount)
       {
         if($amount <=0)
        {
            return $textnumber="Money must be a positive integer greater than 0";
        }
        $Text=array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
        $TextLuythua =array("","thousand", "million", "billion", "trillion", "million billion", "billion billion");
        $textnumber = "";
        $length = strlen($amount);

        for ($i = 0; $i < $length; $i++)
        $unread[$i] = 0;

        for ($i = 0; $i < $length; $i++)
        {
            $so = substr($amount, $length - $i -1 , 1);

            if ( ($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)){
                for ($j = $i+1 ; $j < $length ; $j ++)
                {
                    $so1 = substr($amount,$length - $j -1, 1);
                    if ($so1 != 0)
                        break;
                }

                if (intval(($j - $i )/3) > 0){
                    for ($k = $i ; $k <intval(($j-$i)/3)*3 + $i; $k++)
                        $unread[$k] =1;
                }
            }
        }

        for ($i = 0; $i < $length; $i++)
        {
            $so = substr($amount,$length - $i -1, 1);
            if ($unread[$i] ==1)
            continue;

            if ( ($i% 3 == 0) && ($i > 0))
            $textnumber = $TextLuythua[$i/3] ." ". $textnumber;

            if ($i % 3 == 2 )
            $textnumber = 'percent ' . $textnumber;

            if ($i % 3 == 1)
            $textnumber = 'fifty ' . $textnumber;


            $textnumber = $Text[$so] ." ". $textnumber;
        }

        //Phai de cac ham replace theo dung thu tu nhu the nay
        $textnumber = str_replace("zero fifty", "retail", $textnumber);
        $textnumber = str_replace("retail zero", "", $textnumber);
        $textnumber = str_replace("fifty zero", "fifty", $textnumber);
        $textnumber = str_replace("fifty one", "teen", $textnumber);
        $textnumber = str_replace("fifty five", "fifty five", $textnumber);
        $textnumber = str_replace("fifty one", "fifty one", $textnumber);
        $textnumber = str_replace("fifty five", "teen five", $textnumber);

        return ucfirst($textnumber." AUD");
      }



           // Get: Ip
            function get_ip()
            {
            if(isset($_SERVER['X_FORWARDED_FOR'])){
            if(strpos($_SERVER['X_FORWARDED_FOR'], ',') === false){
            return $_SERVER['X_FORWARDED_FOR'];
            }
            return trim(reset(explode(',', $_SERVER['X_FORWARDED_FOR'])));
            }
            return $_SERVER['REMOTE_ADDR'];
            }
         /****************************************************/
          function getConfig() {
            $result = $this->getDynamic("setting", "", "");
            $info = array();
            while ($rowinfo = $this->nextData($result)) {
              $index = $rowinfo["key_name"];
              $info[$index] = stripslashes($rowinfo["value"]);
            }
            return $info;
          }
         /**************************************************/
         function getLevelMember($parentid,$level,$ms){

             $result = $this->getDynamic("member","parentid in(".$parentid.")","");
             $total = $this->totalRows($result);
             if( $total > 0)
             {
               echo "<div class='level-".$level."'>";
               echo '<div style="background: #FAFAFA; color: #2D82C3; font-size:16px; padding:10px;cursor: Pointer;">
                          Level '.$level.'  -  Thành Viên <span style="float:right;margin-right:29px">có: <span style="color:#f00;">'.$total.'</span> TV</span>
               </div>';
               echo '<table id="mainTable">
                        <thead>
                          <tr style="background:#848484; color: #fff;">
                           <th class="itemText" width="50"><b>STT</b></th>
                           <th class="itemText" width="100"><b>MSTV</b></th>
                           <th class="itemText" width="250"><b>TÊN Thành Viên</b></th>
                           <th class="itemText" width="250"><b>XẾP SAU</b></th>
                           <th class="itemText"><b>NGÀY THAM GIA</b></th>
                          </tr>
                        </thead>
                        <tbody>';

               $strParentId = "";
               $i=1;
               while( $row = $this->nextData($result))
               {
                     $strParentId.=$row['id'].",";
                     $ponser = $this->getInfoColum("member",$row['parentid']);
                     echo '<tr class="cell1">
                        <td class="itemText">'.$i.'</td>
                        <td class="itemText">'.$ms.$row['id'].'</td>
                        <td class="itemText">'.$row['hovaten'].'</td>
                        <td class="itemText">'.$ponser['hovaten'].'</td>
                        <td class="itemText">'.date('d-m-Y',$row['datecreated']).'</td>
                     </tr>';
               }
               $level++;
               $strParentId.='-1';
               echo "</tbody></table>";
               echo "</div>";
               //Goi lai get thanh vien
               return $this->getLevelMember($strParentId,$level,$ms);

             }else
             {
                if($level==1)
                {
                     echo "<div class='level-".$level."'>";
                     echo '<div style="background: #FAFAFA; color: #2D82C3; font-size:16px; padding:10px;cursor: Pointer;">
                                Level '.$level.'  -  Thành Viên <span style="float:right;">có: <span style="color:#f00;">0</span> TV</span>
                     </div>';
                }
                return true;
             }
         }

          function getTotalLevel($parentid,$total){
             $result = $this->getDynamic("member","parentid in(".$parentid.")","");
             if( $this->totalRows($result)> 0)
             {
               $strParentId='';
               while( $row = $this->nextData($result))
               {
                     $strParentId.=$row['id'].",";
               }

               $total++;
               return $this->getTotalLevel($strParentId,$total);
             }else
             {
               return $total;
             }
         }

         function getHaveLevel($parentid){
             $result = $this->getDynamic("member","parentid =".$parentid."","");
             if( $this->totalRows($result)> 0)
             {
                return true;
             }else
             {
                return false;
             }
         }

         //get tree member
         function getTreeMember($parentid,$ms){

             $result = $this->getDynamic("member","parentid in(".$parentid.")","parentid asc");
             $total = $this->totalRows($result);
             if( $total > 0)
             {
               $strParentId = "";
               $i=1;
               $parentidback = 0;
               while( $row = $this->nextData($result))
               {
                  $strParentId.=$row['id'].",";
                  //echo $row['parentid']."==".$parentidback."<br/>";
                  if($parentidback==0)
                  {
                  $str="<ul id=\'ul_".$row['parentid']."\'><li id=\'".$row['id']."\'>".$ms.$row['id']."-".$row['hovaten']."</li></ul>";
                  echo "<script>
                          var branches = $('".$str."').appendTo('#".$row['parentid']."');
                  </script>";
                    $parentidback = $row['parentid'];
                  }else if($parentidback == $row['parentid'])
                  {
                    $str="<li id=\'".$row['id']."\'>".$ms.$row['id']."-".$row['hovaten']."</li>";
                    echo "<script>
                            var branches = $('".$str."').appendTo('#ul_".$row['parentid']."');
                         </script>";
                    $parentidback = $row['parentid'];
                  }else
                  {
                      $str="<ul id=\'ul_".$row['parentid']."\'><li id=\'".$row['id']."\'>".$ms.$row['id']."-".$row['hovaten']."</li></ul>";
                      echo "<script>
                              var branches = $('".$str."').appendTo('#".$row['parentid']."');
                      </script>";
                      $parentidback = $row['parentid'];
                  }


               }
                $strParentId.='-1';
                return $this->getTreeMember($strParentId,$ms);

             }else
             {
                return true;
             }
         }


        /****************************************************/

            // Get: Ban List
          function banlist(){
          global $page, $arrLayout, $banlist;
          if(!isset($banlist)) {
          $banlist = 0;
          $filepath = 'banlist.txt';
          $find = '/'.@file_get_contents($filepath).'|^$/i';
          $condition = $page.$this->get_ip().$_SERVER['HTTP_USER_AGENT'];
          if(preg_match($find,$condition))
                $banlist = 1;
          else $banlist= 0;
          }
          return $banlist;
          }



        function showtitle($page,$url,$lang){
             switch($page)
              {
                 case "home" :
                        break;

                 case "search" :
                        echo "Search | ";
                        break;

                  case "login" :
                        echo "Login | ";
                        break;
                  case "register" :
                        echo "Register | ";
                        break;
                  case "account" :
                        echo "Account | ";
                        break;
                  case "change-password":
                        echo "Change password | ";
                        break;
                  case "forgot-password":
                        echo "Forgot password | ";
                        break;

                  case "checkout":
                        echo "Checkout |";
                        break;
                  case "checkout-complete":
                        echo "Checkout complete |";
                        break;

                  default :

                        break;
              }
          }
}
?>