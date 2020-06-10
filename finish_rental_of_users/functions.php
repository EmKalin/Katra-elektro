<?php

    require('admin/sql_connect.php');

//    FUNKCJA DO POBIERANIA DANYCH O NARZĘDZIACH
    function get_elemets($type){
        global $mysqli;

        switch ($type){
            case 'avalible':
                $sql = "SELECT element_id, element_name, element_description, price, image FROM elements WHERE available = 1";
                break;

            case 'unavalible':
                $sql = "SELECT element_id, element_name, element_description, price, image FROM elements WHERE available = 0 ";
                break;

            case 'select':
                $sql = "SELECT element_id, element_name FROM elements WHERE available = 1 ";
                break;

        }


        $result = $mysqli->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
/////////////////////////////////////////////////////////

//  FUNKCJA DO GENEROWANIA TABLICY ZAMÓWIEŃ


    function generate_orders($id,$type) {
        global $mysqli;


        switch ($type){

            case 0:

                $sql = "SELECT elements.element_name, users.user_name, users.user_lastname, reservations.cost, reservations.from_date, reservations.to_date FROM reservations INNER JOIN  elements ON reservations.element_id = elements.element_id INNER JOIN users ON users.user_id = reservations.client_id WHERE users.user_id = $id && reservations.status = 0";
                break;

            case 1:

                $sql = "SELECT elements.element_name, users.user_name, users.user_lastname, reservations.cost, reservations.from_date, reservations.to_date FROM reservations INNER JOIN  elements ON reservations.element_id = elements.element_id INNER JOIN users ON users.user_id = reservations.client_id WHERE users.user_id = $id && reservations.status = 1";
                break;

            case 2:

                $sql = "SELECT elements.element_name, users.user_name, users.user_lastname, reservations.cost, reservations.from_date, reservations.to_date FROM reservations INNER JOIN  elements ON reservations.element_id = elements.element_id INNER JOIN users ON users.user_id = reservations.client_id WHERE users.user_id = $id && reservations.status = 2";
                break;


            case 3:
                $sql = "SELECT elements.element_name, users.user_name, users.user_lastname, reservations.cost, reservations.from_date, reservations.to_date FROM reservations INNER JOIN  elements ON reservations.element_id = elements.element_id INNER JOIN users ON users.user_id = reservations.client_id WHERE users.user_id = $id && reservations.status = -1";
                break;
        }



        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);


        return $rows;
    }
///////////////////////////////////////////////////////////
/// //    FUNKCJA DO SPRAWDZANIA HASŁA OD UŻYTKOWNIKA

    function get_passes() {
        global $mysqli;

        $sql = "SELECT pass FROM users";

        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
///////////////////
/// //    FUNKCJA DO SPRAWDZANIA HASŁA OD PRACOWNIKA
    function get_passWorkers(){

        global $mysqli;

        $sql = "SELECT pass FROM workers";

        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;

    }

    ///////////////////////////////
/// //    FUNKCJA DO POBIERANIA HASŁA OD UŻYTKOWNIKA

    function check_pas($pass){
        global $mysqli;

        $sql = "SELECT login FROM users WHERE pass = ?";

        if($statement = $mysqli->prepare($sql)){
            if($statement->bind_param('s',$pass)){
                $statement->execute();
                $result = $statement -> get_result();
                $row = $result->fetch_row();


                if(isset($row[0])){
                    $work_log = $row[0];
                } else {
                    die("Niepoprawny login lub hasło!");
                }

            }

        } else {
            die("Zapytanie niepoprawne!");
        }

        return $work_log;
    }



///////////////////////////////
/// //    FUNKCJA DO POBIERANIA HASŁA OD UŻYTKOWNIKA

    function check_pasWorkers($pass){
        global $mysqli;

        $sql = "SELECT login FROM workers WHERE pass = ?";

        if($statement = $mysqli->prepare($sql)){
            if($statement->bind_param('s',$pass)){
                $statement->execute();
                $result = $statement -> get_result();
                $row = $result->fetch_row();
                $work_log = $row[0];

            }

        } else {
            die("Zapytanie niepoprawne!");
        }

        return $work_log;
    }




/////////////////////////////
/// FUNKCJA DO REJESTRACJI

    function createUser($login, $pass, $name, $lastname, $telephone_num){

        global $mysqli;

        $sql = "INSERT INTO users (`login`, `pass`, `user_name`, `user_lastname`, `telephone_num`) VALUES (?,?,?,?,?)";

        if($statement = $mysqli->prepare($sql)){
            if ($statement->bind_param('sssss', $login, $pass, $name, $lastname, $telephone_num)){
                $statement->execute();
                $user_id = $mysqli->insert_id;

                header("Location:../index.php");
            }

        } else {
            die('Niepoprawne zapytanie');
        }


    }
/////////////////////////////
/// FUNKCJA DO REZERWACJI

    function reserve($login, $pass, $element_id, $termin, $days){

        global $mysqli;

        $from_date = $termin;
        $to_date = date('Y-m-d', strtotime($from_date.'+ '.$days.' days'));

        $sql = "SELECT price FROM elements WHERE element_id = $element_id";

        $result = $mysqli->query($sql);
        $row = $result->fetch_row();

        $price = $row[0];
        $cost = $days*$price;

        $sql_2 = "SELECT user_id FROM users WHERE pass = ?";

        if($statement = $mysqli->prepare($sql_2)) {
            if ($statement->bind_param('s', $pass)) {
                $statement->execute();
                $result_id = $statement->get_result();
                $rowOfid = $result_id->fetch_row();
                $work_id = $rowOfid[0];



                $sql_3 = "INSERT INTO reservations (`client_id`, `element_id`, `from_date`, `to_date`, `cost`) VALUES (?,?,?,?,?)";

                if ($statement_2 = $mysqli->prepare($sql_3)) {
                    if ($statement_2->bind_param('iissi', $work_id, $element_id, $from_date, $to_date, $cost)) {
                        $statement_2->execute();

                        header("Location: index.php");
                    }
                }
            }

        }else {
            die("Zapytanie niepoprawne!");
        }




    }

    function getUserId($login){
        global $mysqli;

        $sql = "SELECT user_id FROM users WHERE login = ?";

        if($statement = $mysqli->prepare($sql)){
            if($statement->bind_param('s',$login)){
                $statement->execute();
                $result = $statement -> get_result();
                $row = $result->fetch_row();
                $work_log = $row[0];

            }

        } else {
            die("Zapytanie niepoprawne!");
        }

        return $work_log;

    }

    function getUserHistory($userId,$type)
    {


        global $mysqli;

        switch ($type) {
            case 0:
                $sql = "SELECT id, element_id, from_date, to_date, cost FROM reservations WHERE user_id = $userId and status = 0";
                break;

            case 1:
                $sql = "SELECT id, element_id, from_date, to_date, cost FROM reservations WHERE user_id = $userId and status = 1";
                break;

            case 2:
                $sql = "SELECT id, element_id, from_date, to_date, cost FROM reservations WHERE user_id = $userId and status = 2";
                break;

        }


        $result = $mysqli->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;

    }


    function get_elementName($element_id){

        global $mysqli;


        $sql = "SELECT element_name FROM elements WHERE element_id = $element_id";

        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;

    }

    function name($id){
        global $mysqli;


        $sql = "SELECT user_name FROM users WHERE user_id = $id";

        $result = $mysqli->query($sql);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }

    function reserveId($userId){
        global $mysqli;

        $sql = "SELECT reservations.id FROM reservations INNER JOIN  elements ON reservations.element_id = elements.element_id INNER JOIN users ON users.user_id = reservations.client_id WHERE users.user_id = $userId && reservations.status = 0";

        $result = $mysqli->query($sql);
        $row = $result->fetch_all(MYSQLI_ASSOC);
        //$work_log = $row[0];


        return $row;

    }
?>