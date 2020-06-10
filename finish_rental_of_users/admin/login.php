<?php

    require('../functions.php');

    if(!empty($_POST)){


        session_start();

        if (isset($HTTP_SESSION['isLogged']) && $_SESSION['isLogged']===true){
            header("Location: zamowienia.php");
        }

        require('sql_connect.php');

        $nick =  trim($_POST['nick']);
        $pass = hash('whirlpool',trim($_POST['password']));


        if($nick == "" || $pass == ""){
            die("Niepoprawne dane logowania");
        }

        $sql = "SELECT pass FROM users WHERE login = ?";

        if($statement = $mysqli->prepare($sql)){
            if($statement->bind_param('s',$nick)){
                $statement->execute();
                $result = $statement -> get_result();
                $row = $result->fetch_row();
                $work_password = $row[0];

                if($work_password == $pass){


                    $userId = getUserId($nick);
                    $_SESSION['isLogged'] = true;
                    $_SESSION['user_id'] = $userId;
                    header("Location:zamowienia.php");
                } else {
                    die("Niepoprawne hasło!");
                }

            }
            $mysqli->close();
        } else {
            die("Zapytanie niepoprawne!");
        }

    } else {

        die('Niepoprawne logowanie');
    }


?>