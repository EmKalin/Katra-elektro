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
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/index.php" role="button">Strona główna</a>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/users/users.php" role="button">Użytkownicy</a>
        <a style="text-align:left; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/narzedzia/narzedzia.php" role="button">Narzędzia</a>
        <a style="text-align:center; margin-left:50px;" class="btn btn-primary" href="http://localhost/projekt/worker/orders/orders.php" role="button">Zamówienia</a>
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

    ?>
    <br><br>
    <hr>

    <div style="margin-left:500px;" class="row">
        <div class="column" style="margin-left:0px; margin-top:30px;">
            <a href="users/users.php"><img title="Użytkownicy" src="../icons_homepage/users.png" width="350" height="300"/></a>
        </div>
         <div class="column" style="margin-left:150px; margin-top:80px;">
            <a href="narzedzia/narzedzia.php"><img title="Narzędzia" src="../icons_homepage/narzedzia.png" width="200" height="210"/></a>
        </div>
        <div class="column" style="margin-left:150px; margin-top:100px;">
        <a href="orders/orders.php"><img title="Zamówienia" src="../icons_homepage/orders.png" width="200" height="180"/></a> 
        </div>
    </div>
    <div class="row" margin-left:500px;>
        <div class="column" style="margin-left:650px; margin-top:10px;">
            <a href="users/users.php">Użytkownicy</a>
        </div>
         <div class="column" style="margin-left:300px; margin-top:10px;">
            <a href="narzedzia/narzedzia.php">Narzędzia</a>
        </div>
        <div class="column" style="margin-left:300px; margin-top:10px;">
        <a href="orders/orders.php">Zamówienia</a> 
        </div>
    </div>
</body>
</html>