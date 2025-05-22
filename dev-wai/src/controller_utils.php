<?php

function &get_saved(){
    if (!isset($_SESSION['saved'])) {
        $_SESSION['saved'] = [];
    }

    return $_SESSION['saved'];
}