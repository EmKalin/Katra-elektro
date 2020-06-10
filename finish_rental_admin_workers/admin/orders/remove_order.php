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

    $id_zamowienie = $_GET['id'];
    $delete_zamowienie = "DELETE FROM reservations WHERE id=:ID";

    // // pobieranie danych o narzędziach

    $odbierz_id_narzedzia = "SELECT element_id FROM `reservations` WHERE id=".$id_zamowienie;
    $narz_update = $db->prepare($odbierz_id_narzedzia);
    $narz_update->execute();
    while($narz_id = $narz_update->fetch()){
        $id_elementu = $narz_id['element_id'];
    }
    echo $id_elementu;



    $statement = $db->prepare($delete_zamowienie);
    $statement->bindValue(':ID',$id_zamowienie,PDO::PARAM_INT);
    if($statement->execute()){
        echo "Element został usunięty";

        $update_status_narz = "UPDATE `elements` SET`availability`=:STATUSX WHERE element_id=".$id_elementu;
        $stat_update = $db->prepare($update_status_narz);
        $stat_update->bindValue(':STATUSX', 1, PDO::PARAM_INT);
        $stat_update->execute();
        $narz_update->closeCursor();
        $stat_update->closeCursor();
        $statement->closeCursor();
        header('Location: orders.php');
    }else{
        echo "Element nie został usunięty";
    }
?>