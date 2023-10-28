<?php

class Controller {
    function execute(){
        $a = isset($_GET['param1']) ? $_GET['param1'] : 1;
        if(!empty($_FILES)){
            //we can start uploading files
            echo 'ready to upload files'.$a;
        }
        //check if pincode cookie is set to 1
        if($_COOKIE['pincode']==1){
            echo 'pincode exists';
        }
    }
}