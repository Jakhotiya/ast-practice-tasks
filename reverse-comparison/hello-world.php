<?php

function foo(int $a){

    $a = $a > 10 ? $a : $a*100;

    if($a > 5 ){
        return $a;
    }

    if($a < 3){
        return 3;
    }

    if($a>=0){
        return 0;
    }

    if($a<= -1){
        return -1;
    }

}