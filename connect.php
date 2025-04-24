<?php

$conn =pg_connect("host=localhost user=postgres password=postgres dbname=OpenZagreb");

if(!$conn){
    echo "Neuspješno povezivanje";
}else{
    echo "";
}