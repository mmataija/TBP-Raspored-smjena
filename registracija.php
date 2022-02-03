<?php
if(isset($_POST['submit'])){
    
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $datum_rodjenja= $_POST['datum_rodjenja'];
    $rodni_grad= $_POST['rodni_grad'];
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];


    $con=pg_connect("host=localhost dbname=postgres user=postgres password=m1m71999 port=5432");

    $inputRegistration =pg_query($con,"insert into public.korisnik(id_uloga, ime, prezime, datum_rodjenja, rodni_grad, email, lozinka) 
    values (2,'".$ime."', '".$prezime."', '".$datum_rodjenja."','".$rodni_grad."','".$email."','".sha1($lozinka)."')");

    if($inputRegistration == TRUE){
        echo '<script>alert("Uspješno ste se registrirali! Sada se možete prijaviti!")</script>';
        header('location:../index.php');
    }
    else{
        echo '<script>alert("Provjerite unesene podatke.")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--META-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--LINKS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>Raspored smjena</title>
</head>
<body>
    <div class="glavni">
        <div class="registracija">
            <h3>Registriraj se</h3>
            <div class="forma">
                <form action="" method="post">
               
                    <input name="ime" id="ime" type="text" placeholder="Ime:"><br>
                    <input name="prezime" id="prezime" type="text" placeholder="Prezime:"><br>
					<input name="datum_rodjenja" id="datum_rodjenja" type="date" placeholder="Datum rođenja:"><br>
					<input name="rodni_grad" id="rodni_grad" type="text" placeholder="Rodni grad:"><br>
					<input name="email" id="email" type="text" placeholder="Email:"><br>
					
                    <input name="lozinka" id="lozinka" type="password" placeholder="Lozinka:">
                    <label class="container">
                    <input type="checkbox" onclick="funkcijaZaLozinku()">Prikaži lozinku
                    </label>
                    <script>
                    function funkcijaZaLozinku(){
                    var x=document.getElementById("lozinka");
                    if(x.type=="password"){
                    x.type="text";
                    }else{
                    x.type="password";
                    }
                    }
                    </script>
                   
                    <button type="submit" name="submit" class="button">Registriraj se</button>
                </form>
            </div>

        </div>    
    </div>
</body>
</html>
