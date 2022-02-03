
<?php
    $con=pg_connect("host=localhost dbname=postgres user=postgres password=m1m71999 port=5432");

    $userId = pg_query($con, "SELECT id_korisnik FROM korisnik WHERE email =  '".$_COOKIE['email']."'");
    $userIdFetch = pg_fetch_assoc($userId);

    $noteTrue= pg_query($con,"SELECT * FROM poruka  WHERE vazno = 'TRUE' AND krajnji_rok > NOW() ORDER BY krajnji_rok" );
    $noteFalse= pg_query($con,"SELECT * FROM poruka WHERE vazno = 'FALSE' AND krajnji_rok > NOW() ORDER BY krajnji_rok" );
    $err = '';
    if(isset($_POST['submit2'])){
        $noteTitle = $_POST['noteTitle'];
        $note = $_POST['note'];
        $deadline = $_POST['deadline'];

        $inputNote =pg_query($con,"insert into poruka(id_korisnik,naslov,poruka, vazno, krajnji_rok) 
        values ('".$userIdFetch['id_korisnik']."','".$noteTitle."', '".$note."', FALSE, '".$deadline."')");

        if($inputNote == TRUE){
            header('location:oglasnaPloca.php');
        }else{
            echo "<script>alert('$err')</script>";
        }
    }
    if(isset($_POST['submit'])){
        
        $noteTitle = $_POST['noteTitle'];
        $note = $_POST['note'];
        $deadline = $_POST['deadline'];

        $inputNote =pg_query($con,"insert into poruka(id_korisnik,naslov,poruka, vazno, krajnji_rok) 
        values ('".$userIdFetch['id_korisnik']."','".$noteTitle."', '".$note."', TRUE, '".$deadline."')");

        if($inputNote == TRUE){
            header('location:oglasnaPloca.php');
        }else{
            echo '<script>alert("Rok mora biti vrijeme koje je u budućnosti!")</script>';
        }
    }

    error_reporting( error_reporting() & ~E_NOTICE );
    error_reporting(E_ERROR | E_PARSE);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>Oglasna ploča</title>
</head>
<body>
<h1>OGLASNA PLOČA</h1>
    <div class="poruke">
        <?php while($noteTrueFetch= pg_fetch_assoc($noteTrue)){ 
            $timeLeft = pg_query($con,"SELECT '".$noteTrueFetch['krajnji_rok']."' - NOW() AS preostalo FROM poruka");
            $timeLeftFetch = pg_fetch_assoc($timeLeft);
			$autor = pg_query($con,"SELECT CONCAT(ime,' ', prezime) AS autor FROM korisnik WHERE id_korisnik = '".$noteTrueFetch['id_korisnik']."'");
			$autorFetch = pg_fetch_assoc($autor);
        ?>
        <div class="noteTrue">
            <div class="notesContent">
                <p class="title"><?php echo $noteTrueFetch['naslov']?></p>
                <p><?php echo $noteTrueFetch['poruka']?></p>
                <p class="remaining">PREOSTALO JOŠ: </p>
               <p> <?php echo $timeLeftFetch['preostalo']?><p>
			   <a>-obavijest napisao/la: <br><?php echo $autorFetch['autor']?></a>
            </div>
        </div>
        <?php } ?>
        <?php while($noteFalseFetch= pg_fetch_assoc($noteFalse)){ 
            $timeLeftNew = pg_query($con,"SELECT '".$noteFalseFetch['krajnji_rok']."' - NOW()  AS preostalo FROM poruka");
            $timeLeftNewFetch = pg_fetch_assoc($timeLeft);
			$autor = pg_query($con,"SELECT CONCAT(ime,' ', prezime) AS autor FROM korisnik WHERE id_korisnik = '".$noteFalseFetch['id_korisnik']."'");
			$autorFetch = pg_fetch_assoc($autor);
        ?>
        <div class="noteFalse">
        <div class="notesContent">
                <p class="title"><?php echo $noteFalseFetch['naslov']?></p>
                <p><?php echo $noteFalseFetch['poruka']?></p>
                <p class="remaining">PREOSTALO JOŠ: </p>
                <p><?php echo $timeLeftNewFetch['preostalo']?><p>
				<a>-obavijest napisao/la: <br><?php echo $autorFetch['autor']?></a>
            </div>
        </div>
        <?php } ?>

        <div class="dodajPoruku" id="dodajPoruku">
            <div class="dodajFormu">
                <form action="" method="post">
				
                <input name="noteTitle" id="noteTitle" type="text" class="form-control" placeholder="Naslov napomene" aria-label="Naslov napomene" aria-describedby="basic-addon1">
				<a>Opis obavijesti:</a>
                <textarea id="note" name="note" rows="4" cols="50" placeholder="Opis napomene" class="form-control" style="margin-top: 0px;">
                </textarea>
				<a>Datum i vrijeme događaja:</a>
                <input name="deadline" id="deadline" class="form-control" type="datetime-local" placeholder="Vrijeme početka">
				
                <div class="buttonsImportance">
                    <button type="submit" name="submit" class="btn btn-success" style="background-color: rgb(177, 112, 112);">Označi kao važno!</button>
                    <button type="submit" name="submit2" class="btn btn-success" style="background-color: rgb(154, 204, 144)">Označi kao manje važno!</button>
                </div>

                </form>
            </div>
        </div>
    </div>


    <div class="buttons">
        <div class="button" id="buttonSubject">
            <p>Ostavi poruku</p>
		</div>
			<?php if($_COOKIE['uloga'] == 'sef'){ ?>
					<a href="mainSef.php"><div class="button" id="buttonNotes">
			<?php }else{ ?>
					<a href="mainRadnik.php"><div class="button" id="buttonNotes">
			<?php } ?>
			<p>Idi na raspored</p>
	</div></a>
</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // OPEN SIGN-UP CONTAINER
    $(document).ready(function(){
       
       $(document.getElementById("dodajPoruku")).hide();
       $("#buttonSubject").click(function(){
         $(document.getElementById("dodajPoruku")).hide();
       });
       var elem="#dodajPoruku";
       $( document ).on( 'keydown', function ( e ) {
           if ( e.keyCode === 27 ) { // ESC
               $( elem ).fadeOut();
           }
       });
       $("#buttonSubject").click(function(){
         $(document.getElementById("dodajPoruku")).fadeIn();
       });
     });

</script>
</html>


