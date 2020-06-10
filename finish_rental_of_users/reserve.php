<?php

    require('functions.php');

    if(!empty($_POST)){

        $login = trim($_POST['login']);
        $pass = hash('whirlpool',trim($_POST['pass']));
        $element_id = $_POST['narzedzia'];
        $termin = $_POST['termin'];
        $days = $_POST['days'];

        foreach ($_POST as $p) {
            if($p == ''){
                die('Uzupełnij pole!');
            }
        }

        $today = date('Y-m-d');
        if($termin < $today){
            die('Niepoprawna data!');
        }

        if($days < 1 || $days > 14) {
            die('Niepoprawna liczba dni!');
        }

        ///////////
        ///
        $work_l = check_pas($pass);

        if($work_l == ''){
            die('Niepoprawne hasło lub login!');
        } elseif($work_l != $login)  {
            die("Niepoprawny login lub hasło!");
        }


        reserve($login, $pass, $element_id, $termin, $days);
    }

?>