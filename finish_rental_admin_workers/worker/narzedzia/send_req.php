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

    // pobieranie danych o narzędziach
    $statement2 = $db->prepare($dodaj_narz);



    // dodawanie elementów
    $wartosc_name = $_REQUEST['element_input_name'];
    $wartosc_desc = $_REQUEST['element_input_desc'];
    $wartosc_avail =$_REQUEST['availability_input'];
    $wartosc_price =$_REQUEST['element_input_price'];
    $wartosc_img =$_REQUEST['element_input_image'];


    if($wartosc_avail == "on") $wartosc_avail = true;
    else $wartosc_avail = false;
    echo gettype($wartosc_name); 
    echo gettype($wartosc_desc); 
    echo gettype($wartosc_avail);
    
    $statement2->bindValue(':NAMEIN',$wartosc_name,PDO::PARAM_STR);
    $statement2->bindValue(':DESCIN',$wartosc_desc,PDO::PARAM_STR);
    $statement2->bindValue(':AVAIL',$wartosc_avail,PDO::PARAM_BOOL);
    $statement2->bindValue(':PRICE',$wartosc_price,PDO::PARAM_INT);
    $statement2->bindValue(':IMG_X',$wartosc_img, PDO::PARAM_STR);
    if($statement2->execute()){
        echo "Nowy element został wprowadzony";
        $statement2->closeCursor();
        header('Location: narzedzia.php');
    }else{
        echo "NIE UDALO SIE";
    }
?>