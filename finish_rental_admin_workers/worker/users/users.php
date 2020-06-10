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
    <h2 style="text-align:center; margin-bottom:50px;">Panel pracownika</h2>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/index.php" role="button">Strona główna</a>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/users/users.php" role="button">Użytkownicy</a>
    <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/narzedzia/narzedzia.php" role="button">Narzędzia</a>
    <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/orders/orders.php" role="button">Zamówienia</a>
    <a style="text-align:center; margin-left:300px;" class="btn btn-primary" href="http://localhost/projekt/logout.php" role="button">Wyloguj się</a>
    </div>
    <?php
        // powitanie
        $name = $_POST['inputLogin'];
        echo "<h3 style='color:blue; text-align:right' >$name</h3>";
    ?>
    <br><br>
    <hr>
    
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
        echo "<h3 style='color:blue; text-align:right;' >$name</h3>";

        // ZAPYTANIE - Wyświetl narzędzia z bazy danych
        $wys_users = "SELECT * FROM users";


        // pobieranie danych o narzędziach
        $statement = $db->prepare($wys_users);

        // wykonanie zapytania i wdrożenie
        $statement->execute();

    ?>


    <h3 style="text-align:center;">Użytkownicy</h3>

    <div>
        <div style="margin-left:200px; margin-right:200px;">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Num</th>
                    <th scope="col">Login</th>
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col">Numer telefonu</th>
                </tr>
            </thead>
                <?php
                    while($user = $statement->fetch()){
                        echo "<tr>";
                        echo "<td style='text-align:center;'>". $user['user_id'] .'</td>';
                        echo "<td style='text-align:center;'>".$user['login'].'</td>';
                        echo "<td style='text-align:center;'>". $user['user_name'].'</td>';
                        echo "<td style='text-align:center;'>". $user['user_lastname'].'</td>';
                        echo "<td style='text-align:center;'>". $user['telephone_num'].'</td>';
                        echo "</tr>";
                    }
                    $statement->closeCursor();
                ?>
        </table>
        </div>
    </div>


</body>
</html>