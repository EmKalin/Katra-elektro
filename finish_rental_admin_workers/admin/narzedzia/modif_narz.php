<!DOCTYPE html>
<html>
<head>
<!--Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>KaTra</title>
</head>
<body>
    <div style="text-align:center;">
    <h2 style="text-align:center; margin-bottom:50px;">Panel administratora</h2>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/index.php" role="button">Strona główna</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/users/users.php" role="button">Użytkownicy</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/workers/workers.php" role="button">Pracownicy</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/narzedzia/narzedzia.php" role="button">Narzędzia</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/orders/orders.php" role="button">Zamówienia</a>
    <a style="text-align:center; margin-left:300px;" class="btn btn-primary" href="http://localhost/projekt/logout.php" role="button">Wyloguj się</a>
    </div>
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


        // powitanie
        $name = $_POST['inputLogin'];
        echo "<h3 style='color:blue; text-align:right' >$name</h3>";

        $id_element_selected = $_GET['id'];
        // ZAPYTANIE - Wyświetl narzędzia z bazy danych
        $wys_narz = "SELECT * FROM elements WHERE element_id=".$id_element_selected;

        // ZAPYTANIE - Dodaj narzędzie do bazy danych
        $dodaj_narz = "INSERT INTO `elements`(`element_id`, `element_name`, `element_description`, `availability`) VALUES (:NAMEIN,:DESCIN,:AVAIL)";
        
        // zmienne do modyfikacji
        $pokaz_wybrane= "SELECT * FROM elements WHERE element_id=".$id_element_selected;
        // pobieranie danych o narzędziach
        $statement = $db->prepare($wys_narz);
        $statement2 = $db->prepare($dodaj_narz);
        $statement3= $db->prepare($pokaz_wybrane);

        // wykonanie zapytania i wdrożenie
        $statement->execute();
        $statement3->execute();
        while($element = $statement3->fetch()){
            $id_x =  $element['element_id'] ;
            $name_x = $element['element_name'];
            $desc_x =  $element['element_description'];
            $price_x = $element['price'];
            $image_X = $element['image'];
            if($element['availability']==1) $avail_x="checked=true";
            else $avail_x = "";
        }
    ?>
    <br><br>
    <hr>
    <h3 style="text-align:center;">Modyfikacja narzędzia</h3>
    <div>
        <form action="send_req2_mod.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-4" style="margin-left:200px;">
                    <label for="element_input_name">Nazwa</label>
                    <input type="text" pattern=".{3,}" required title="Minimum 3 znaki" value="<?php echo $name_x ?>" class="form-control" id="element_input_name" name="element_input_name" placeholder="Nazwa urządzenia">
                </div>
                <div class="form-group col-md-1" style="margin-left:50px;">
                    <label for="element_input_price">Cena</label>
                    <input type="float" value="<?php echo $price_x ?>" class="form-control" id="element_input_price" name="element_input_price" placeholder="Cena urządzenia">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" <?php echo $avail_x ?> class="form-check-input" id="availability_input" name="availability_input" style="vertical-align:bottom; position:relative;margin-left:20px;margin-top:40px;">
                    <label class="form-check-label" for="availability_input" style="display:inline-block;">Urządzenie jest dostępne</label>
                </div>
                <div class="form-group col-md-6" style="margin-left:200px;">
                <label for="element_input_desc">Opis</label>
                    <textarea type="text" class="form-control" id="element_input_desc" name="element_input_desc" rows="3" placeholder="Opis urządzenia"><?php echo $desc_x ?></textarea>
                </div>
                <div class="form-group col-md-2" style="margin-left:50px;">
                    <label for="element_input_image">Nazwa pliku</label>
                    <input type="text" value="<?php echo $image_X ?>" class="form-control" id="element_input_image" name="element_input_image" placeholder="Nazwa pliku ze zdjęciem">
                </div>
                <div style="margin-left:200px;">
                    <button type="submit" class="btn btn-primary mb-2" formaction="narzedzia.php">Wróc</button>
                    <button type="submit" name="modify_element_button" id="modify_element_button" class="btn btn-primary mb-2" >Modyfikuj</button>
                </div>
                <input type="hidden" name="element_id" value=<?php echo $id_x ?>>
            </div>
        </form>
    </div>
    <hr>
    <div>
        <div style="margin-left:200px; margin-right:200px;">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Num</th>
                    <th scope="col">Przedmiot</th>
                    <th scope="col">Zdjęcie</th>
                    <th scope="col">Opis</th>
                    <th scope="col">Dostępność</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
                <?php
                    while($element = $statement->fetch()){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>". $element['element_id'] .'</td>';
                        echo "<td style='text-align:center;'>". $element['element_name'].'</td>';
                        echo "<td style='text-align:center;'>"."<img src=".'"img/'. $element['image'] . '"'. 'width="100" height="100" />'.'</td>';
                        echo "<td style='text-align:center;'>". $element['element_description'].'</td>';
                        if($element['availability'] == '1')
                            echo "<td style='text-align:center;'>". "Dostępny" .'</td>';
                        else{
                            echo "<td style='text-align:center;'>". "Niedostępny" .'</td>';
                            }
                        echo "<td style='text-align:center;'>". "<a href='modif_narz.php?id=".$element['element_id']."'>" ."Zmień". "</a>" .
                             "<a href='usun_narz.php?id=".$element['element_id']."'>" ."  Usuń". "</a>"
                            ."</td>";
                        echo "</tr>";
                    }
                    $statement->closeCursor();
                ?>
        </table>
        </div>
    </div>
<hr><br>
</body>
</html>
