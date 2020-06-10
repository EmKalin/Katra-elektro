<?php

    require('functions.php');

    session_start();

    if (isset($HTTP_SESSION['isLoggedUser']) && $_SESSION['isLoggedUser']===true){
        header("Location: proba.php");
    }


    if(!empty($_POST)){
        $login = trim($_POST['nick']);
        $pass = hash('whirlpool',trim($_POST['password']));


        if($login == "" || $pass == ""){
            die("Niepoprawne dane logowania");
        }


        $work_l = check_pas($pass);

        if($work_l == ''){
            die('Niepoprawne hasło lub login!');
        } elseif($work_l != $login)  {
            die("Niepoprawny login lub hasło!");
        }





        if($login == $work_l){

            $userId = getUserId($login);

            //$_SESSION['user_id'] = 3;
            session_start();
            $_SESSION['isLogged'] = true;
            $_SESSION['id'] = $userId;

            header("Location: admin/proba.php");

        } //elseif ($work_lW == $login){

          //  session_start();
         //   $_SESSION['isLogged'] = true;
//
         //   if (isset($HTTP_SESSION['isLogged']) && $_SESSION['isLogged']===true){
         //       header("Location: zamowienia.php");
          //  }
        //}

    }


?>
