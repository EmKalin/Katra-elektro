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

    $user_id = $_GET['id'];
    $usun_user = "DELETE FROM workers WHERE id =:ID";

    // pobieranie danych o narzędziach
    $statement = $db->prepare($usun_user);



    // dodawanie elementów

    
    $statement->bindValue(':ID',$user_id,PDO::PARAM_INT);

    if($statement->execute()){
        echo "Nowy element został wprowadzony";
        $statement->closeCursor();
        header('Location: workers.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>