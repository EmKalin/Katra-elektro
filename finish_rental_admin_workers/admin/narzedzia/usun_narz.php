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

    $id_element_selected = $_GET['id'];
    $delete_narzedzie = "DELETE FROM elements WHERE element_id=:ID";
    echo $delete_narzedzie;
    // // pobieranie danych o narzędziach
    $statement = $db->prepare($delete_narzedzie);

    
    $statement->bindValue(':ID',$id_element_selected,PDO::PARAM_INT);
    if($statement->execute()){
        echo "Element został usunięty";
        $statement->closeCursor();
        header('Location: narzedzia.php');
    }else{
        echo "Element nie został usunięty";
    }
?>