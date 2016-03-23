<?php
/**
 * Created by PhpStorm.
 * User: pg3f4
 * Date: 4/13/2015
 * Time: 11:39 AM
 */
function display($num){
    for($x = 0; $x < $num; $x++){
        for($y = 0; $y < $num; $y++){
            echo "0";
        }
        echo "<br>";
    }
}

display(10);