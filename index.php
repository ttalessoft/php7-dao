<?php
    
    require_once("config.php");

    $usr = new Usuario();

    // carrega apenas um usuario
    // $usr->loadbyId(2);

    // carrega todos os usuários
    // $lista = Usuario::getList();

    // carrega uma busca pelo nome do usuario
    // $lista = Usuario::search("jose");

    // valida uma tentativa de login
    // $usr->login("user", "senha1234");
    // echo $usr;

    // $usr = new Usuario("maria", "m4r1@");
    // $usr->setDeslogin("ttales r g s silva");
    // $usr->setDessenha("aa45bb");
    // $usr->insert();
    // echo $usr;

    // $usr->loadbyId(49);
    // $usr->update("TTSOFT", "7760f7");
    // echo $usr;

    $usr->loadbyId(49);

    $usr->delete();

    echo $usr;