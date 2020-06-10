<?php
    require('../functions.php');

    if(!empty($_POST)){
        $login = trim($_POST['nick']);
        $pass = hash('whirlpool',trim($_POST['password']));
        $name = trim($_POST['imie']);
        $lastname = trim($_POST['nazwisko']);
        $telephone_num = trim($_POST['telefon']);

        foreach ($_POST as $p){
            if($p == ''){
                die('Uzupełnij pole!');
            }
        }

        $rows = get_passes();


        foreach ($rows as $r) {
            if($pass == $r['pass']){
                die('Hasło istnieje już w sewisie. Proszę wybrać inne.');
            }
        }

        $rowsFromWorks = get_passWorkers();

        foreach ($rowsFromWorks as $w) {
            if($pass == $w['pass']){
                die('Hasło istnieje już w sewisie. Proszę wybrać inne.');
            }
        }


        createUser($login, $pass, $name, $lastname, $telephone_num);

    }
?>
