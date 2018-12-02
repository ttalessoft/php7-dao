<?php
    
    require_once("config.php");

    $usr = new Usuario();

    $usr->loadbyId(2);

    echo $usr;