<?php
    function ddd($var, $stop = false)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        if ($stop) {
            exit();
        }

    }

