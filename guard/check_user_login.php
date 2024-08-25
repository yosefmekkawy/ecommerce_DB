<?php
function check_login(){
    if(!(isset($_SESSION['id']))){
        header('location:../login.php');
    }
}