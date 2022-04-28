<?php 
 
// Load the database configuration file 
$servername = "localhost";
$username = "root";
$password = "";
$database = "house_rental_db";
// Create connection
$conn =  mysqli_connect($servername, $username, $password,$database, 3307);
 
// Fetch records from database 
$query ="SELECT * FROM users ORDER BY id ASC"; 
 $result=mysqli_query($conn,$query);
if(mysqli_num_rows($result) > 0){ 
    $delimiter = ","; 
    $filename = "user-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('ID', ' NAME', 'USER NAME', 'PASSWORD', 'Role Id'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = mysqli_fetch_assoc($result)){ 
        $lineData = array($row['id'], $row['name'], $row['username'], $row['password'],$row['type']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 

exit; 

 
?>