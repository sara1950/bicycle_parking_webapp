<?php
    include 'connect.php';
    $id = "";
    $vrsta = "";
    $naziv = "";
    $br_stalaka = "";
    $br_bicikala = "";
    $godina = "";
    $nadleznost = "";

    $errormsg ="";
    $successmsg ="";


  if($_SERVER ['REQUEST_METHOD'] =='GET'){

    if(!isset($_GET['id'])){
        header ("location:index.php");
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT objectid, vrsta, naziv, broj_stalaka, broj_bicikala, godina_postavljanja, gradska_cetvrt FROM parkiralista WHERE objectid='$id' ORDER BY objectid ";
    $result = pg_query($conn,$sql);
    $rows = pg_fetch_assoc($result);

if(!$rows){
    header ("location:index.php");
    exit;
}


$id = $rows ['objectid'];
$vrsta = $rows ['vrsta'];
$naziv = $rows ['naziv'];
$br_stalaka = $rows ['broj_stalaka'];
$br_bicikala = $rows ['broj_bicikala'];
$godina = $rows ['godina_postavljanja'];
$nadleznost = $rows ['gradska_cetvrt'];

}else{
    $id = $_POST['id'];
    $vrsta = $_POST['vrsta'];
    $naziv = $_POST['naziv'];
    $br_bicikala = $_POST['br_bicikala'];
    $br_stalaka = $_POST['br_stalaka'];
    $godina = $_POST['godina'];
    $nadleznost = $_POST['nadleznost'];


        do{
            if(empty($id) || empty($vrsta) || empty($naziv) || empty($br_bicikala) || empty($br_stalaka) || empty($godina) || empty($nadleznost)){
                $errormsg = "Popunite tražena polja!";
                break;
            }

            $sql = "UPDATE parkiralista SET objectid='$id' ,vrsta ='$vrsta', naziv= '$naziv', broj_stalaka='$br_stalaka',broj_bicikala='$br_bicikala',godina_postavljanja='$godina',gradska_cetvrt='$nadleznost' WHERE objectid='$id'";
            $result = pg_query($conn,$sql);

            if(!$result){
                echo 'Invalid query: '.pg_last_error();
break;
            }
            
    $successmsg = 'Zapis je uspješno promijenjen!';




        }while(false);

}

?>






<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container my-5">
            <h2>Ažuriraj zapis</h2>

            <?php
            if(!empty($errormsg)){
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>$errormsg</strong>
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  
  </button>
</div>
                ";
            }
            ?>
            <form method="post">
                <!-- <input type="hidden" name="objectid" value="<?php echo $id;?>"> -->
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">ID</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="id" value="<?php echo $id;?>" require>
    </div>
                </div>
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Vrsta</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="vrsta" value="<?php echo $vrsta;?>" require>
    </div>
                </div>
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Naziv</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="naziv" value="<?php echo $naziv;?>" require>
    </div>
                </div>
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Broj stalaka</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="br_stalaka" value="<?php echo $br_stalaka;?>" require>
    </div>
                </div>
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Broj bicikala</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="br_bicikala" value="<?php echo $br_bicikala;?>" require>
    </div>
                </div>
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Godina postavljanja</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="godina" value="<?php echo $godina;?>" require>
    </div>
                </div>
                <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Nadležnost</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="nadleznost" value="<?php echo $nadleznost;?>">
    </div>
                </div>

<?php

if (!empty ($successmsg)){
    echo "<div class='row mb-3'><div class='offset sm-3 col-sm-6'>
    <div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>$successmsg</strong> 
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  </button>
</div></div></div>";
}
?>


                <div class="row mb-3">
                <div class="offset sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Spremi</button>
</div>
<div class="col-sm-3 d-grid">
<a class="btn btn-outline-primary" href="index.php" role="button">Otkaži</a>
</div>
<div class="col-sm-3 d-grid">
<a class="btn btn-outline-primary" href="index.php" role="button">Početna</a>
</div>
</div>
    </form>
            </div>
    </body>
    </html>