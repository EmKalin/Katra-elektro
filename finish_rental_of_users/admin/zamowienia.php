<?php
    session_start();
    require('../functions.php');
    if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !== true){
        die("Dostęp zabroniony!!!");
    }


?>


<!doctype html>
<html lang="pl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Konto użytkownika</title>
</head>
<body>
    <div class="col-12 mt-5">
        <h2 class="text-center font-weight-bold p.5">PANEL UŻYTKOWNIKA</h2>
        <div class="text-center">
            <a href="logout.php" class="m-2">WYLOGUJ</a>
        </div>
    </div>

    <div class="col-12 mt-5">
        <h2 class="text-center font-weight-bold p.5">ZAMÓWIENIA</h2>
    </div>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">

                    </th>
                    <th scope="col">Narzędzie</th>
                    <th scope="col">Data wypożyczenia</th>
                    <th scope="col">Data zwrotu</th>
                    <th scope="col">Koszt</th>
                    <th scope="col">Akcja</th>

                </tr>
                </thead>
                <tbody>


                <?php

                    require('../functions.php');
                    $rows = getUserHistory($_SESSION['id'],0);


                    for($i = 0;$i<count($rows);$i++) {
                        echo '<tr>';
                        echo '<th scope="row">'.($i+1).'</th>';

                        //$name = get_elementName($rows[$i]['element_id']);
                        echo '<td>'.$rows[$i]['element_id'].'</td>';
                        echo '<td>'.$rows[$i]['from_date'].'</td>';
                        echo '<td>'.$rows[$i]['to_date'].'</td>';
                        echo '<td>'.$rows[$i]['cost'].'</td>';

                        //$zamow_id = $rows[$i]['id'];
                        //echo "<td style='text-align:center;'>"."<a href='usun.php' id=".$zamow_id."'>" ."  Anuluj". "</a>" ."</td>";
                        echo '</tr>';
                    }
                ?>

                </tbody>
            </table>


        </div>
    </div>



    <div class="col-12 mt-5">
        <h2 class="text-center font-weight-bold p.5">WYPOŻYCZENIA</h2>
    </div>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">

                    </th>
                    <th scope="col">Narzędzie</th>
                    <th scope="col">Data wypożyczenia</th>
                    <th scope="col">Data zwrotu</th>
                    <th scope="col">Koszt</th>


                </tr>
                </thead>
                <tbody>


                <?php
                require('../functions.php');
                $rows = getUserHistory($_SESSION['id'],1);

                for($i = 0;$i<count($rows);$i++) {
                    echo '<tr>';
                    echo '<th scope="row">'.($i+1).'</th>';

                    //$name = get_elementName($rows[$i]['element_id']);
                    //echo '<td>'.$name.'</td>';
                    echo '<td>'.$rows[$i]['element_id'].'</td>';
                    echo '<td>'.$rows[$i]['from_date'].'</td>';
                    echo '<td>'.$rows[$i]['to_date'].'</td>';
                    echo '<td>'.$rows[$i]['cost'].'</td>';

                    echo '</tr>';
                }
                ?>

                </tbody>
            </table>


        </div>
    </div>



    <div class="col-12 mt-5">
        <h2 class="text-center font-weight-bold p.5">ZWRÓCONE</h2>
    </div>

    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">

                    </th>
                    <th scope="col">Narzędzie</th>
                    <th scope="col">Data wypożyczenia</th>
                    <th scope="col">Data zwrotu</th>
                    <th scope="col">Koszt</th>


                </tr>
                </thead>
                <tbody>


                <?php
                require('../functions.php');
                $rows = getUserHistory($_SESSION['id'],2);

                for($i = 0;$i<count($rows);$i++) {
                    echo '<tr>';
                    echo '<th scope="row">'.($i+1).'</th>';

                    //$name = get_elementName($rows[$i]['element_id']);
                   // echo '<td>'.$name.'</td>';
                    echo '<td>'.$rows[$i]['element_id'].'</td>';
                    echo '<td>'.$rows[$i]['from_date'].'</td>';
                    echo '<td>'.$rows[$i]['to_date'].'</td>';
                    echo '<td>'.$rows[$i]['cost'].'</td>';

                    echo '</tr>';
                }
                ?>

                </tbody>
            </table>


        </div>
    </div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>