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

    $id_zamowienie_selected = (int)($_REQUEST['id']);
    $modif_zamowienie = "UPDATE reservations SET `status`=:STAT WHERE `id`=".$id_zamowienie_selected;

    $get_element_id = "SELECT element_id FROM reservations WHERE id=".$id_zamowienie_selected;
    $wez_id_urz = $db->prepare($get_element_id);
    $wez_id_urz->execute();
    while($element = $wez_id_urz->fetch()){
        $id_elementu =  $element['element_id'];
    }

    // pobieranie danych o narzędziach
    $statement_mod = $db->prepare($modif_zamowienie);

    $statement_mod->bindValue(':STAT',1,PDO::PARAM_INT);
    // $statement_mod->bindValue(':ID_X',$id_element_selected,PDO::PARAM_INT);
    if($statement_mod->execute()){
        echo "Nowy element został wprowadzony";

            $update_status_narz = "UPDATE `elements` SET`availability`=:STATUSX WHERE element_id=".$id_elementu;
            $stat_update = $db->prepare($update_status_narz);
            $stat_update->bindValue(':STATUSX', 0, PDO::PARAM_INT);
            $stat_update->execute();
            $stat_update->closeCursor();

            $statement_mod->closeCursor();
            header('Location: ../rents/rents.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>