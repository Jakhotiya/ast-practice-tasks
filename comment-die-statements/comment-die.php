<?php
// This program comments out die statement
class DieStmts {

    function commentDie(int $a){
        if($a > 5 ){
            die($a);
        }
        die;
    }
    function  dontCommentExit(){
        exit(1);
    }
}
