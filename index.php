<?php
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg  bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand text-white" href="#">Web Aplikacija</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active text-white " aria-current="page" href="index.php"><i class="fa fa-home"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white " href="#" id="btn" ><i class="fa fa-envelope"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white " href="https://sindikatbiciklista.hr/" target="_blank"><i class="fa fa-globe"></i></a>
              </li>
            </ul>
            <form class="d-flex" role="search">
       
              <input  class="form-control me-2" type="text" id="input" onkeyup="findData()" placeholder="Pretraži po ID" value ="">
            </form>
          </div>
        </div>

      </nav>



      <main>

      <div id="modal" class="modal">
<div class="modal-content">
<span class="close">&times;</span>
    <div class="form-popup" id="myForm">
  <form action="" class="form-container">
    <h4>Pošalji poruku</h4>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="msg"><b>Poruka</b></label>
    <textarea id="msg" name="msg" rows="4" cols="20"></textarea>
<div class="buttons">
    <button type="submit" class="btn">Pošalji</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Zatvori</button>
</div>
  </form>
</div>
  </div>

</div>

<script>


var modal = document.getElementById("modal");
var span = document.getElementsByClassName("close")[0];
var btn = document.getElementById("btn");


btn.onclick = function() {
  modal.style.display = "block";
}


span.onclick = function() {
  modal.style.display = "none";
}


</script>
















        <div class="parent-container d-flex">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6" id="left">
                     <h2>Popis parkališta za bicikle</h2>
                     <a class="btn btn-primary" role="button" href ="create.php" >Novi zapis</a>
<br>
<br>
                        <table id="table" class="table table-sm">
                        <thead class="zaglavlje" id="zaglavlje">
                            <tr>
                            <td>ID</td>
                            <td>Vrsta</td>
                            <td>Naziv</td>
                            <td>Broj stalaka</td>
                            <td>Broj bicikala</td>
                            <td>Godina postavljanja</td>
                            <td>Nadležnost</td>
                            </tr>
                    

                            
                        </thead>
<tbody id="table-sort">


<?php
include 'connect.php';

$sql = "SELECT objectid, vrsta, naziv, broj_stalaka, broj_bicikala, godina_postavljanja, gradska_cetvrt FROM parkiralista";
$result = pg_query($conn,$sql);
if(!$result){
  echo 'Invalid query';
}

while ($rows = pg_fetch_assoc($result)){

  echo '<tr>
    <td>'.$rows['objectid'].'</td>
    <td>'.$rows['vrsta'].'</td>
    <td>'.$rows['naziv'].'</td>
    <td>'.$rows['broj_stalaka'].'</td>
    <td>'.$rows['broj_bicikala'].'</td>
     <td>'.$rows['godina_postavljanja'].'</td>
      <td>'.$rows['gradska_cetvrt'].'</td>
     <td><a class="btn btn-primary btn-sm" href="edit.php?id='.$rows['objectid'].'">Ažuriraj</a></td>
     <td><a class="btn btn-danger btn-sm" href="delete.php?id='.$rows['objectid'].'">Obriši</a></td>
    </tr>';
}

?>



</tbody>




                        </table>
                    
                    </div>
                </div>
            </div>
            
         
                    <div class="col-lg-6" id="right">
                        <div id="map"></div>
                      <script src="map.js"></script>
                    </div>
               
            
        </div>



        <script>
window.onscroll = function() {myFunction()};

var head = document.getElementById("zaglavlje");
var sticky = head.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    head.classList.add("sticky");
  } else {
    head.classList.remove("sticky");
  }
}
</script>















      </main>




      <script>
function findData(){
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("input");
  filter = input.value.toUpperCase();
  table = document.getElementById("table-sort");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}



  









        </script>








</body>
</html>