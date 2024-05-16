
<?php
$servername="localhost";
$username="root";
$password="";
$database_name="School System";
$conn=mysqli_connect($servername,$username,$password,$database_name);
try{
    $conn=mysqli_connect($servername,$username,$password,$database_name);
     //echo "connected successfully";
;}
catch(mysqly_sql_exception){
    echo "Unable to connect succefully";
}


?>
