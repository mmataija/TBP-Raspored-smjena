<?php
     $con=pg_connect("host=localhost dbname=postgres user=postgres password=m1m71999 port=5432");
     
    $id_korisnik = pg_query($con, "SELECT CONCAT(ime,' ', prezime) AS korisnik, id_korisnik FROM public.korisnik where email =  '".$_COOKIE['email']."'");
    $dohvati_id_korisnika = pg_fetch_assoc($id_korisnik);
    
    
    if(isset($_POST['submit2'])){
        $nazivMjeseca=$_POST['nazivMjeseca'];
        $mjesecId = pg_query($con,"SELECT * FROM mjesec WHERE naziv = '".$nazivMjeseca."'");
        $dohvati_id_mjeseca = pg_fetch_assoc($mjesecId);
		}else{
			$dohvati_id_mjeseca['id_mjesec']=date('m');
		}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>Raspored</title>
   </head>

<div class="buttons">
	<p style="padding-top: 8px; float: left; width: 300px;">Prijavljeni ste kao: <?php echo $dohvati_id_korisnika['korisnik']?><br></p>
    <a href="index.php">
		<div class="button" id="buttonNotes" style="height: 40px; margin-left: 50px; margin-top: 50px;">
			<p style="padding-top: 8px;">Odjavi se</p>
		</div>
	</a>
</div>

<div class="raspored" style="margin-top: 50px;">
        <div id="radniDani">Ponedjeljak</div>
        <div id="radniDani">Utorak</div>
        <div id="radniDani">Srijeda</div>
        <div id="radniDani">Četvrtak</div>
        <div id="radniDani">Petak</div>
        <div id="vikendDani">Subota</div>
        <div id="vikendDani">Nedjelja</div>
     
        <div id="radniDani" class="dan">
            <?php 
            $smjenePon = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
            while( $dohvatiSmjenePon= pg_fetch_assoc($smjenePon)){
                    $pon= pg_query($con,"SELECT s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=1 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjenePon['id_smjena']."' ORDER BY s.vrijeme_pocetka");
            while($dohvatiPon= pg_fetch_assoc($pon)){
            ?>
            <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
				<form action="mainSef.php" method="post">
				<button type="submit" name="delete" value="<?php echo $dohvatiPon['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
				</form>
				<?php echo $dohvatiPon['naziv']?><br>
				<?php echo $dohvatiPon['ime']?>
				<?php echo " "?>
				<?php echo $dohvatiPon['prezime']?><br>
                <?php echo $dohvatiPon['vrijeme_pocetka']?> - <?php echo $dohvatiPon['vrijeme_zavrsetka']?>
            </div>
            <?php } }?>
        </div>
        <div id="radniDani" class="dan">
            <?php 
            $smjeneUto = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
            while( $dohvatiSmjeneUto= pg_fetch_assoc($smjeneUto)){
                
                $uto= pg_query($con,"SELECT s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=2 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjeneUto['id_smjena']."' ORDER BY s.vrijeme_pocetka");
            
            while($dohvatiUto= pg_fetch_assoc($uto)){ 
            ?>
            <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
				<form action="mainSef.php" method="post">
				<button type="submit" name="delete" value="<?php echo $dohvatiUto['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
				</form>
                <?php echo $dohvatiUto['naziv']?><br>
				<?php echo $dohvatiUto['ime']?>
				<?php echo " "?>
				<?php echo $dohvatiUto['prezime']?><br>
                <?php echo $dohvatiUto['vrijeme_pocetka']?> - <?php echo $dohvatiUto['vrijeme_zavrsetka']?>
            </div>
            <?php }} ?>
        </div>
        <div id="radniDani" class="dan">
            <?php 
            $smjeneSri = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
            while( $dohvatiSmjeneSri= pg_fetch_assoc($smjeneSri)){
                
                $sri= pg_query($con,"SELECT s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=3 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjeneSri['id_smjena']."' ORDER BY s.vrijeme_pocetka");
            
            while($dohvatiSri= pg_fetch_assoc($sri)){ 
                ?>
                <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
					<form action="mainSef.php" method="post">
					<button type="submit" name="delete" value="<?php echo $dohvatiSri['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
					</form>
                    <?php echo $dohvatiSri['naziv']?><br>
					<?php echo $dohvatiSri['ime']?>
					<?php echo " "?>
					<?php echo $dohvatiSri['prezime']?><br>
                    <?php echo $dohvatiSri['vrijeme_pocetka']?> - <?php echo $dohvatiSri['vrijeme_zavrsetka']?>
                </div>
            <?php }}?>
        </div>
        <div id="radniDani" class="dan">
            <?php 
             $smjeneCet = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
             while( $dohvatiSmjeneCet= pg_fetch_assoc($smjeneCet)){
                 
                 $cet= pg_query($con,"SELECT s.id_smjena, s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=4 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjeneCet['id_smjena']."' ORDER BY s.vrijeme_pocetka");
            
            while($dohvatiCet= pg_fetch_assoc($cet)){ 
                ?>
                <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
					<form action="mainSef.php" method="post">
					<button type="submit" name="delete" value="<?php echo $dohvatiCet['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
					</form>
                    <?php echo $dohvatiCet['naziv']?><br>
					<?php echo $dohvatiCet['ime']?>
					<?php echo " "?>
					<?php echo $dohvatiCet['prezime']?><br>
                    <?php echo $dohvatiCet['vrijeme_pocetka']?> - <?php echo $dohvatiCet['vrijeme_zavrsetka']?>
				</div>
            <?php }} ?>
        </div>
        <div id="radniDani" class="dan">
            <?php 
            $smjenePet = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
            while( $dohvatiSmjenePet= pg_fetch_assoc($smjenePet)){
                             
                $pet= pg_query($con,"SELECT s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=5 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjenePet['id_smjena']."' ORDER BY s.vrijeme_pocetka");
            
            while($dohvatiPet= pg_fetch_assoc($pet)){
                ?>
                <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
					<form action="mainSef.php" method="post">
					<button type="submit" name="delete" value="<?php echo $dohvatiPet['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
					</form>
                    <?php echo $dohvatiPet['naziv']?><br>
					<?php echo $dohvatiPet['ime']?>
					<?php echo " "?>
					<?php echo $dohvatiPet['prezime']?><br>
                    <?php echo $dohvatiPet['vrijeme_pocetka']?> - <?php echo $dohvatiPet['vrijeme_zavrsetka']?>
                </div>
            <?php }} ?>

        </div>
        <div id="vikendDani" class="dan">
            <?php 
            $smjeneSub = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
            while( $dohvatiSmjeneSub= pg_fetch_assoc($smjeneSub)){
                                         
            $sub= pg_query($con,"SELECT s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=6 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjeneSub['id_smjena']."' ORDER BY s.vrijeme_pocetka");
            
            while($dohvatiSub= pg_fetch_assoc($sub)){ 
                ?>
                <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
					<form action="mainSef.php" method="post">
					<button type="submit" name="delete" value="<?php echo $dohvatiSub['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
					</form>
                    <?php echo $dohvatiSub['naziv']?><br>
					<?php echo $dohvatiSub['ime']?>
					<?php echo " "?>
					<?php echo $dohvatiSub['prezime']?><br>
                    <?php echo $dohvatiSub['vrijeme_pocetka']?> - <?php echo $dohvatiSub['vrijeme_zavrsetka']?>
                </div>
            <?php } }?>

        </div>
        <div id="vikendDani" class="dan">
            <?php
            $smjeneNed = pg_query($con, "SELECT id_smjena FROM odradjuje WHERE id_korisnik = '".$dohvati_id_korisnika['id_korisnik']."'");
            while( $dohvatiSmjeneNed= pg_fetch_assoc($smjeneNed)){
                                                     
            $ned= pg_query($con,"SELECT s.id_smjena, s.naziv, s.vrijeme_pocetka, s.vrijeme_zavrsetka, k.ime, k.prezime FROM smjena s 
											JOIN odradjuje o ON s.id_smjena = o.id_smjena 
											JOIN korisnik k ON o.id_korisnik = k.id_korisnik 
											WHERE s.id_dan=7 AND s.id_mjesec='".$dohvati_id_mjeseca['id_mjesec']."' AND s.id_smjena = '".$dohvatiSmjeneNed['id_smjena']."' ORDER BY s.vrijeme_pocetka");
                        
            while($dohvatiNed= pg_fetch_assoc($ned)){ 
                ?>
                <div class="subject" style="background: #999999; height: 100px; padding-top: 10px; position: relative;" >
					<form action="mainSef.php" method="post">
					<button type="submit" name="delete" value="<?php echo $dohvatiNed['id_smjena']?>" class="btn btn-danger" style='float: right; border-radius: 50%; border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; width: 24px; position: absolute; top: 4px; right: 4px;'>X</button>
					</form>
                    <?php echo $dohvatiNed['naziv']?><br>
					<?php echo $dohvatiNed['ime']?>
					<?php echo " "?>
					<?php echo $dohvatiNed['prezime']?><br>
                    <?php echo $dohvatiNed['vrijeme_pocetka']?> - <?php echo $dohvatiNed['vrijeme_zavrsetka']?>
                </div>
            <?php } }?>
        </div>
	</div>
    </div>
        <div class="buttons">
        <a href="oglasnaPloca.php"><div class="button" id="buttonNotes" style="margin-left: 175px;">
                    <p>Oglasna ploča</p>
                </div></a>
    </div>
     <div class="timeSelect">
            <form action="" method="post">
                <select name ="nazivMjeseca" id="select" class="form-control">
                    <?php
                    $mjesec = pg_query($con,"SELECT * FROM public.mjesec");
                    while($mjesecFetch=pg_fetch_array($mjesec)){
                    ?>
                    <option><?php echo $mjesecFetch["naziv"]; ?></option><br><br><br>
                    <?php
                    }
                    ?>
                    </select>
                    <button type="submit" name="submit2" class="btn btn-success" style="margin-top: 20px;">Odaberi razdoblje</button>
            </form>
    </div>
</body>
</html>
