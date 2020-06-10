<?php



    // deklaracja zmiennych na potrzeby łączenia się z bazą danych
    $dns = "mysql:host=localhost;dbname=projekt_db";
    $username = "root";
    $password = "mysql";


    // łączenie z bazą danych
    // w przypadku niepowodzenia, błąd zostanie wyświetlony na stronie
    try{
        $db = new PDO($dns,$username,$password);


    }catch(Exception $e){
        $error_message = $e->getMessage();
        echo "<p>Error message : $error_message</p>";

    }

    //funkcja do sprawdzenia hasla dla pracownikow

    function check_pasWorkers($pass){
        global $db;
        $sql = "SELECT login FROM workers WHERE pass =:ID";

        if($statement = $db->prepare($sql)){
            if($statement->bindValue(':ID',$pass,PDO::PARAM_STR)){
                $statement->execute();
                while($result = $statement->fetch()){
                    $user_login = $result['login'];
                    echo $user_login."AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
                }
            }

        } else {
            die("Zapytanie niepoprawne!");
        }

        return $user_login;
    }


    function get_idWorkers($login){

        global $db;

        $sql = "SELECT id FROM workers WHERE login =:ID";

        if($statement = $db->prepare($sql)){
            if($statement->bindValue(':ID',$login,PDO::PARAM_STR)){
                $statement->execute();
                while($result = $statement->fetch()){
                    $worker_id = $result['id'];
                    echo $worker_id."AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
                }
            }

        } else {
            die("Zapytanie niepoprawne!");
        }

        return $worker_id;
    }


    function get_accessl($login){
        
        global $db;

        $sql = "SELECT accessl FROM workers WHERE login =:ID";

        if($statement = $db->prepare($sql)){
            if($statement->bindValue(':ID',$login,PDO::PARAM_STR)){
                $statement->execute();
                while($result = $statement->fetch()){
                    $worker_access = $result['accessl'];
                }
            }

        } else {
            die("Zapytanie niepoprawne!");
        }

        return $worker_access;
    }


    // OBSŁUGA SESJI
    session_start();

    if (isset($HTTP_SESSION['isLogged']) && $_SESSION['isLogged']===true){
        //localizacja do pracowników
        header("Location: worker/index.php");
    } elseif (isset($HTTP_SESSION['isLoggedBoss']) && $_SESSION['isLoggedBoss']===true){
        //lokalizacja do bossa
        header("Location: admin/index.php");
    }



    if(!empty($_POST)){
        $login = trim($_POST['nick']);
        $pass = $_POST['password'];
        if($login == "" || $pass == ""){
            header("Location: strona_login.php");
        }

        // OBSLUGA LOGIN DLA PRACOWNIKÓW
        $work = check_pasWorkers($pass);
        $accessl = get_accessl($login);

        if($work == ''){
            die('Niepoprawne hasło lub login!');

        }elseif($work != $login)  {
            die("Niepoprawny login lub hasło!");

        }

        if($work == $login){
            $workers_id = get_idWorkers($login);
            // kiedy to admin ( accessl = 1)
            if($accessl == 1){
                session_start();
                $_SESSION['isLoggedBoss'] = true;
                header("Location: admin/index.php");
                return;
            }

            session_start();
            $_SESSION['isLogged'] = true;
            $_SESSION['id_wor'] = $workers_id;

            //dodaj plik do jakiego będziesz się przenosił
            header("Location: worker/index.php");

        }

    }


?>
