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

    $id_element_selected = (int)($_REQUEST['element_id']);
    $modif_narzedzie = "UPDATE elements SET `element_name`=:NAMEIN, `element_description`=:DESCIN, `availability`=:AVAIL, `price`=:PRICE , `image`=:IMG_X WHERE `element_id`=".$id_element_selected;

    // pobieranie danych o narzędziach
    $statement_mod = $db->prepare($modif_narzedzie);



    // dodawanie elementów
    $wartosc_name = $_REQUEST['element_input_name'];
    $wartosc_desc = $_REQUEST['element_input_desc'];
    $wartosc_avail =$_REQUEST['availability_input'];
    $wartosc_price = $_REQUEST['element_input_price'];
    $wartosc_img = $_REQUEST['element_input_image'];

    if($wartosc_avail == "on") $wartosc_avail = true;
    else $wartosc_avail = false;

    $statement_mod->bindValue(':NAMEIN',$wartosc_name,PDO::PARAM_STR);
    $statement_mod->bindValue(':DESCIN',$wartosc_desc,PDO::PARAM_STR);
    $statement_mod->bindValue(':AVAIL',$wartosc_avail,PDO::PARAM_BOOL);
    $statement_mod->bindValue(':PRICE',$wartosc_price,PDO::PARAM_INT);
    $statement_mod->bindValue(':IMG_X',$wartosc_img,PDO::PARAM_STR);
    // $statement_mod->bindValue(':ID_X',$id_element_selected,PDO::PARAM_INT);
    if($statement_mod->execute()){
        echo "Nowy element został wprowadzony";
        $statement_mod->closeCursor();
        header('Location: narzedzia.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>