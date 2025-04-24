<?php
  include 'connect.php';


if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM parkiralista WHERE objectid='$id'";
    $result = pg_query($conn,$sql);
    $rows = pg_fetch_assoc($result);
    



}

header("location:index.php");
exit();


?>