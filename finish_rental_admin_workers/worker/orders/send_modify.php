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

    $id_zamowienie_selected = (int)($_REQUEST['zamow_id']);
    $modif_zamowienie = "UPDATE reservations SET `client_id`=:CLIENT_ID, `element_id`=:ELEMENT_ID, `from_date`=:FROMDATE, `to_date`=:TODATE , `status`=:STAT WHERE `id`=".$id_zamowienie_selected;

    // pobieranie danych o narzędziach
    $statement_mod = $db->prepare($modif_zamowienie);



    // dodawanie elementów
    $wartosc_client = $_REQUEST['user_input_name'];
    $wartosc_urz = $_REQUEST['element_input_name'];
    $wartosc_status = $_REQUEST['user_input_status'];
    $wartosc_od =$_REQUEST['data_od'];
    $wartosc_do = $_REQUEST['data_do'];

    echo $wartosc_client;
    echo $wartosc_urz;
    echo $wartosc_status;
    echo $wartosc_od;
    echo $wartosc_do;

    if($wartosc_status == "Wypożycz") $wartosc_avail = 1;
    elseif($wartosc_status == "Rezerwuj") $wartosc_avail = 0;
    elseif($wartosc_status == "Zwrócone") $wartosc_avail = 2;
    elseif($wartosc_status == "Rezygnacja (rez)") $wartosc_avail = -1;
    elseif($wartosc_status == "Anulowanie (wyp)") $wartosc_avail = -2;

    $statement_mod->bindValue(':CLIENT_ID',$wartosc_client,PDO::PARAM_INT);
    $statement_mod->bindValue(':ELEMENT_ID',$wartosc_urz,PDO::PARAM_INT);
    $statement_mod->bindValue(':FROMDATE',$wartosc_od,PDO::PARAM_STR);
    $statement_mod->bindValue(':TODATE',$wartosc_do,PDO::PARAM_STR);
    $statement_mod->bindValue(':STAT',$wartosc_avail,PDO::PARAM_INT);
    // $statement_mod->bindValue(':ID_X',$id_element_selected,PDO::PARAM_INT);
    if($statement_mod->execute()){
        echo "Nowy element został wprowadzony";

        if($wartosc_avail == 1){
            $update_status_narz = "UPDATE `elements` SET`availability`=:STATUSX WHERE element_id=".$wartosc_urz;
            $stat_update = $db->prepare($update_status_narz);
            $stat_update->bindValue(':STATUSX', 0, PDO::PARAM_INT);
            $stat_update->execute();
            $stat_update->closeCursor();
        }elseif($wartosc_avail == -2 || $wartosc_avail == -1 || $wartosc_avail == 2 || $wartosc_avail == 0 ){
            $update_status_narz = "UPDATE `elements` SET`availability`=:STATUSX WHERE element_id=".$wartosc_urz;
            $stat_update = $db->prepare($update_status_narz);
            $stat_update->bindValue(':STATUSX', 1, PDO::PARAM_INT);
            $stat_update->execute();
            $stat_update->closeCursor();
        }

        $statement_mod->closeCursor();
        header('Location: orders.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>