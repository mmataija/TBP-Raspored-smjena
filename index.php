<?php
if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $password = $_POST['lozinka'];

    setcookie('email',$email ,time()+10000);

    $con=pg_connect("host=localhost dbname=postgres user=postgres password=m1m71999 port=5432");
    $login = pg_query($con,"SELECT * FROM public.korisnik WHERE email= '".$email."' AND lozinka = '".sha1($password)."'");      
    $loginFetch= pg_fetch_assoc($login);
    
    if($loginFetch==true){
		echo '<script>alert("Uspješno ste se ulogirali. Možete nastaviti sa radom!")</script>';
		if($loginFetch['id_uloga']==1){
			setcookie('uloga','sef' ,time()+10000);
			header('location:mainSef.php');
		}else{
			setcookie('uloga','radnik' ,time()+10000);
			header('location:mainRadnik.php');
		}
    }else{
        echo '<script>alert("Prijava nije uspjela! Provjerite podatke!")</script>';
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
    <title>Rapored smjena</title>
</head>
<body>
    <div class="glavni">
        <div class="prijava">
            <h3>Prijava</h3>
            <div class="forma">
                <form action="" method="post">
                   <input name="email" id="email" type="text" placeholder="Vaš email:"><br>
                   
                    <input name="lozinka" id="lozinka" type="password" placeholder="Vaša lozinka:">
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
                    <button type="submit" name="submit" class="button" value="Submit">Prijava</button>
                </form>
            </div>
            
            <a href="registracija.php">Idi na registraciju!</a>
        </div>    
    </div>
</body>
</html>

