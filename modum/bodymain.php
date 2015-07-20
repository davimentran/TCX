<?php
    switch ($page) {

      case "login":
      case "home":
            include("member/_login.php");
            break;

      case "register":
            include("member/_register.php");
            break;

      case "account":
      case "ho-so-ca-nhan":
            include("member/_infoAccount.php");
            break;

      case "change-password":
      case "doi-mat-khau":
            include("member/_changepwd.php");
            break;

       case "forgot-password":
            include("member/forgot_password.php");
            break;
       case "cay-he-thong":
            include("member/_cayhethong.php");
            break;
       case "bang-pha-he":
            include("member/_bangphahe.php");
            break;
       case "bang-ke-hoa-hong":
            include("member/_bangkehoahong.php");
            break;

      default :
            include("member/_login.php");
            break;
   }
 ?> 
