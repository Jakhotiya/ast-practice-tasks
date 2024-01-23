<?php

echo "Hello world";

class Foo {
    function getText(){
        return "Hello world";
    }
}

function helloWorld($str){
    echo $str;
}

// Following key should not be modified
$data = [
    "Hello World" => 1
];

helloWorld("Hello World");
