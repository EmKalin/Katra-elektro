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

    $user_id = $_REQUEST['user_id'];
    $modify_user = "UPDATE `users` SET `login` =:LOGX, `pass`=:PASSX, `user_name` =:NAMEX, `user_lastname` =:LASTX, `telephone_num` =:PHONEX WHERE `users`.`user_id` =".$user_id;
    // pobieranie danych o narzędziach
    $statement = $db->prepare($modify_user);


    // dodawanie elementów
    $login = $_REQUEST['login_input'];
    $pass = $_REQUEST['pass_input'];
    $name =$_REQUEST['name_input'];
    $last =$_REQUEST['lastname_input'];
    $phone =$_REQUEST['phone_input'];

    
    $statement->bindValue(':LOGX',$login,PDO::PARAM_STR);
    $statement->bindValue(':PASSX',$pass,PDO::PARAM_STR);
    $statement->bindValue(':NAMEX',$name,PDO::PARAM_STR);
    $statement->bindValue(':LASTX',$last,PDO::PARAM_STR);
    $statement->bindValue(':PHONEX',$phone,PDO::PARAM_INT);
    if($statement->execute()){
        echo "Nowy element został wprowadzony";
        $statement->closeCursor();
        header('Location: users.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>