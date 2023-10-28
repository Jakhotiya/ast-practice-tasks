<?php

/**
 * In this task only line number 9 should change
 */

class Foo {
    public function execute(){
        if(count($_GET['q']) > 3){
            return 1;
        }
        return 0;
    }
}

function bar():string{
    $a = new Foo();
    $result = $a->execute();

    if($result>=1){
        return 'hello';
    }else{
        return 'world';
    }

}

if(strlen(bar()) < 5 ){
    echo 'hello world';
}

echo $_GET['q'] >= 5 ? 'Hello':'World';