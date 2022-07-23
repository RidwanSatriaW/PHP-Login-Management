<?php

namespace ridwan\Belajar\PHP\MVC\App {

    function header(string $value){
        echo $value;
    }

}

namespace ridwan\Belajar\PHP\MVC\Service {

    function setcookie(string $name, string $value){
        echo "$name: $value";
    }

}