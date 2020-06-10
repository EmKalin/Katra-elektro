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

    $worker_id = $_REQUEST['worker_id'];
    $modify_worker = "UPDATE `workers` SET `login` =:LOGX, `pass`=:PASSX, `nick` =:NAMEX, `accessl` =:LASTX WHERE `id` =".$worker_id;
    // pobieranie danych o narzędziach
    $statement = $db->prepare($modify_worker);


    // dodawanie elementów
    $login = $_REQUEST['login_input'];
    $pass = $_REQUEST['pass_input'];
    $name =$_REQUEST['name_input'];
    $accessl =$_REQUEST['user_input_status'];

    
    $statement->bindValue(':LOGX',$login,PDO::PARAM_STR);
    $statement->bindValue(':PASSX',$pass,PDO::PARAM_STR);
    $statement->bindValue(':NAMEX',$name,PDO::PARAM_STR);
    $statement->bindValue(':LASTX',$accessl,PDO::PARAM_INT);
    if($statement->execute()){
        echo "Nowy element został wprowadzony";
        $statement->closeCursor();
        header('Location: workers.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>