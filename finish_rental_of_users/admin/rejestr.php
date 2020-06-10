<!doctype html>
<html lang="pl ">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>

    <div class="col-12 mt-5">
        <h1 class="text-center font-weight-bold">Rejestracja</h1>
    </div>

    <form action="check_rej.php" class="form-singin mt-5" method="POST">
        <div class="col-12 d-flex justify-content-center mt-2">
            <label for="nick" class="sr-only">Login</label>
            <input type="text" name="nick" id="nick" placeholder="login" class="col-lg-3 col-md-6 col-sm-12 m-3 form-control">

        </div>

        <div class="col-12 d-flex justify-content-center mt-2">
            <label for="password" class="sr-only">Hasło</label>
            <input type="password" name="password" id="password" placeholder="hasło" class="col-lg-3 col-md-6 col-sm-12 m-3 form-control">

        </div>


        <div class="col-12 d-flex justify-content-center mt-2">
            <label for="imie" class="sr-only">Imię</label>
            <input type="text" name="imie" id="imie" placeholder="imię" class="col-lg-3 col-md-6 col-sm-12 m-3 form-control">

        </div>

        <div class="col-12 d-flex justify-content-center mt-2">
            <label for="nazwisko" class="sr-only">Nazwisko</label>
            <input type="text" name="nazwisko" id="nazwisko" placeholder="nazwisko" class="col-lg-3 col-md-6 col-sm-12 m-3 form-control">

        </div>

        <div class="col-12 d-flex justify-content-center mt-2">
            <label for="telefon" class="sr-only">Telefon</label>
            <input type="tel" name="telefon" id="telefon" placeholder="nr telefonu" class="col-lg-3 col-md-6 col-sm-12 m-3 form-control">

        </div>

        <div class="col-12 d-flex justify-content-center mt-2">

            <input type="submit" value="Utwórz konto" class="btn btn-primary col-lg-3 col-md-6 col-sm-12 m-3">

        </div>

        <div class="col-12 d-flex justify-content-center mt-2">
            <h5 class="text-center">Po utworzeniu konta możesz korzystać z wypożyczalni</h5>
        </div>

    </form>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html