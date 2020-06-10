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
    <h2 style="text-align:center; margin-bottom:50px;;">Panel administratora</h2>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/index.php" role="button">Strona główna</a>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/users/users.php" role="button">Użytkownicy</a>
        <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/workers/workers.php" role="button">Pracownicy</a>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/narzedzia/narzedzia.php" role="button">Narzędzia</a>
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
        $wys_user = "SELECT * FROM users ORDER BY login";
        $wys_narz = "SELECT * FROM elements";

        $wys_zamowienia = 'SELECT reservations.id, elements.element_name as element_name,
                            users.user_lastname as user_lastname ,users.user_name as user_name ,
                            reservations.from_date, reservations.to_date , elements.price as element_cost,
                            reservations.status
                            FROM reservations
                            INNER JOIN elements ON reservations.element_id = elements.element_id
                            INNER JOIN users ON reservations.client_id = users.user_id
                            WHERE status = -1
                            ORDER BY reservations.id DESC';

        $statement2 = $db->prepare($wys_narz);
        $statement = $db->prepare($wys_zamowienia);
        $statement3 = $db->prepare($wys_user);

        $statement->execute();
        $statement2->execute();
        $statement3->execute();

    ?>
    <br><br>
    <hr>
    <h3 style="text-align:center;">Zamówienia</h3>
    <div style="text-align:left;">
        <a style="text-align:center; margin-left:200px; margin-bottom:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/orders/orders.php" role="button">Wszystkie</a>
        <a style="text-align:center; margin-left:50px; margin-bottom:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/orders/reservations/reservations.php" role="button">Rezerwacje</a>
        <a style="text-align:center; margin-left:50px; margin-bottom:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/orders/rents/rents.php" role="button">Wypożyczenia</a>
        <a style="text-align:center; margin-left:50px; margin-bottom:50px;" class="btn btn-primary" href="http://localhost/projekt/admin/orders/history/history.php" role="button">Historia</a>

    </div>
    <div style="text-align:left;">
        <a style="text-align:center; margin-left:350px; margin-bottom:50px;" class="btn btn-secondary" href="http://localhost/projekt/admin/orders/reservations/reservations.php" role="button">Aktwyne</a>
        <a style="text-align:center; margin-left:50px; margin-bottom:50px;" class="btn btn-secondary" href="http://localhost/projekt/admin/orders/reservations/cancelled_reservations.php" role="button">Anulowane</a>
    <div>
        <div style="margin-left:200px; margin-right:200px;">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Num zamówienia</th>
                    <th scope="col">Przedmiot</th>
                    <th scope="col">Użytkownik</th>
                    <th scope="col">Od (data)</th>
                    <th scope="col">Do (data)</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Status</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
                <?php
                    while($element = $statement->fetch()){
                        $data_init = strtotime(substr($element['from_date'],0,10));
                        $data_end = strtotime(substr($element['to_date'],0,10));
                        $koszt = (($data_end-$data_init)/60/60/24)*$element['element_cost'];
                        echo "<tr>";
                        echo "<td style='text-align:center;'>". $element['id'] .'</td>';
                        echo "<td style='text-align:center;'>". $element['element_name'].'</td>';
                        // echo "<td style='text-align:center;'>"."<img src=".'"img/'. $element['image'] . '"'. 'width="100" height="100" />'.'</td>';
                        echo "<td style='text-align:center;'>". $element['user_name']. ' '. $element['user_lastname'].'</td>';
                        echo "<td style='text-align:center;'>".$element['from_date'].'</td>';
                        echo "<td style='text-align:center;'>".$element['to_date'].'</td>';
                        echo "<td style='text-align:center;'>".$koszt.'</td>';
                        // zamówienie start
                        if($element['status'] == 0){
                            echo "<td style='text-align:center;'>".'Zarezerwowane'.'</td>';
                        }
                        elseif($element['status'] == 1){
                            echo "<td style='text-align:center;'>".'Wypożyczone'.'</td>';
                        }elseif($element['status'] == 2){
                            echo "<td style='text-align:center;'>".'Zwrócone'.'</td>';
                        }elseif($element['status'] == -1){
                            echo "<td style='text-align:center;'>".'Rezygnacja (rez)'.'</td>';
                        }elseif($element['status'] == -2){
                            echo "<td style='text-align:center;'>".'Anulowanie (wyp)'.'</td>';
                        }
                        echo "<td style='text-align:center;'>". "<a href='../modify_order.php?id=".$element['id']."'>" ."Zmień". "</a>" .
                             "<a href='../remove_order.php?id=".$element['id']."'>" ."  Usuń". "</a>"
                            ."</td>";
                        echo "</tr>";
                    }
                    $statement->closeCursor();
                ?>
        </table>
        </div>
    </div>
<hr><br>
    <div>
        <form action="../add_order.php" method="post">
            <label style="margin-left:200px;margin-bottom:50px;" for="form_x">Dodaj zamówienie</label>
            <div class="form-row" id="form_x">
                <div class="form-group col-md-2" style="margin-left:200px;">
                    <label for="element_input_name">Urządzenie</label>
                    <select disable selected value id="element_input_name" name="element_input_name" class="form-control">
                        <?php
                        while($element_x = $statement2->fetch()){
                            echo "<option>".$element_x['element_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2" style="margin-left:100px;">
                    <label for="user_input_name">Użytkownik</label>
                    <select disable selected value id="user_input_name" name="user_input_name" class="form-control">
                        <?php
                        while($user_x = $statement3->fetch()){
                            echo "<option>".$user_x['login']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2" style="margin-left:100px;">
                    <label for="user_input_status">Status</label>
                    <select disable selected value id="user_input_status" name="user_input_status" class="form-control">
                        <option>Wypożycz</option>
                        <option>Rezerwuj</option>
                        <option>Zwrócone</option>
                        <option>Rezygnacja (rez)</option>
                        <option>Anulowanie (wyp)</option>
                    </select>
                </div>
                <div class="form-group col-md-4" style="margin-left:200px; margin-top:50px;">
                    <label for="data_od">Data rozpoczęcia</label>
                    <input type="date" id="data_od" name="data_od">
                </div>
                <div class="form-group col-md-4" style="margin-left:-220px; margin-top:50px;">
                    <label for="data_do">Data zakończenia</label>
                    <input type="date" id="data_do" name="data_do">
                </div>
                <div style="margin-left:0px;margin-top:50px;">
                    <button type="submit" name="add_element_button" id="add_element_button" class="btn btn-primary mb-2" >Dodaj</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>