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


    $dodaj_narz = "INSERT INTO elements ( element_name, element_description, price , image ,availability) VALUES (:NAMEIN,:DESCIN,:PRICE,:IMG_X,:AVAIL)";
    $dodaj_zam = "INSERT INTO reservations (client_id, element_id, from_date, to_date, price, status) VALUES (:CLIENT,:ELEMENT,:OD,:DO,:PRICE,:STAT)";

    $pobierz_id_elementu = "SELECT element_id FROM `elements` WHERE element_name =:ELEM";

    $pobierz_id_user = "SELECT user_id FROM users WHERE login=:USERX";
    // dodawania zamówienia
    $statement = $db->prepare($dodaj_zam);
    // pobieranie id elementu
    $statement2 = $db->prepare($pobierz_id_elementu);
    // pobieranie id usera
    $statement3 = $db->prepare($pobierz_id_user);



    // pobieranie nazwy elementu i przetworzenie na ID zgodnie z wymogami tabeli
    $wartosc_name = $_REQUEST['element_input_name'];
    $statement2->bindValue(':ELEM',$wartosc_name,PDO::PARAM_STR);
    $statement2->execute();
    while($element = $statement2->fetch()){
        $id_elementu =  $element['element_id'];
        echo $id_elementu;
    }

    // pobieranie nazwy użytkownika i przetworzenie na ID
    $wartosc_user = $_REQUEST['user_input_name'];
    $statement3->bindValue(':USERX',$wartosc_user,PDO::PARAM_STR);
    $statement3->execute();
    while($user = $statement3->fetch()){
        $id_user = $user['user_id'];
        echo $id_user;
    }


    $wartosc_status =$_REQUEST['user_input_status'];


    $wartosc_od =$_REQUEST['data_od'];


    $wartosc_do =$_REQUEST['data_do'];



    $wartosc_price = 10;

    if($wartosc_status == "Wypożycz") $wartosc_avail = 1;
    elseif($wartosc_status == "Rezerwuj") $wartosc_avail = 0;
    elseif($wartosc_status == "Zwrócone") $wartosc_avail = 2;
    elseif($wartosc_status == "Rezygnacja (rez)") $wartosc_avail = -1;
    elseif($wartosc_status == "Anulowanie (wyp)") $wartosc_avail = -2;

    if($statement->bindValue(':CLIENT',$id_user,PDO::PARAM_INT)){
        echo "id usera ".$id_user;
    }
    if($statement->bindValue(':ELEMENT',$id_elementu,PDO::PARAM_INT)){
        echo " id elementu ".$id_elementu;
    }
    if($statement->bindValue(':OD',$wartosc_od,PDO::PARAM_STR)){
        echo "od ".$wartosc_od;
    }
    if($statement->bindValue(':DO',$wartosc_do,PDO::PARAM_STR)){
        echo "do ".$wartosc_do;
    }
    if($statement->bindValue(':PRICE',$wartosc_price, PDO::PARAM_INT)){
        echo "cena ".$wartosc_price;
    }
    if($statement->bindValue(':STAT',$wartosc_avail, PDO::PARAM_INT)){
        echo "status ".$wartosc_avail;
    }
    if($statement->execute()){
        echo "Nowy element został wprowadzony";

        if($wartosc_avail == 1){
            $update_status_narz = "UPDATE `elements` SET`availability`=:STATUSX WHERE element_id=".$id_elementu;
            $stat_update = $db->prepare($update_status_narz);
            $stat_update->bindValue(':STATUSX', 0, PDO::PARAM_INT);
            $stat_update->execute();
            $stat_update->closeCursor();
        }elseif($wartosc_avail == -2 || $wartosc_avail == -1 || $wartosc_avail == 2 || $wartosc_avail == 0 ){
            $update_status_narz = "UPDATE `elements` SET`availability`=:STATUSX WHERE element_id=".$id_elementu;
            $stat_update = $db->prepare($update_status_narz);
            $stat_update->bindValue(':STATUSX', 1, PDO::PARAM_INT);
            $stat_update->execute();
            $stat_update->closeCursor();
        }

        $statement->closeCursor();
        header('Location:orders.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>