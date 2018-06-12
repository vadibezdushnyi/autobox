<?php
    if(WP_LOGIN){
        require_once("admin_view.php");
    }else{
        require_once("admin_login.php");
    }