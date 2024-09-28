<?php
$conn = new mysqli("localhost",  
            "root", "","mytimetable"); 
  
if ($conn->connect_error) { 
    die("Connection failure: " 
        . $conn->connect_error); 
}
// else{
//     echo "connection successfull";
// }
?>