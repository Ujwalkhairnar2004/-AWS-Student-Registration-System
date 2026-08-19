<?php 
$host="YOUR-RDS-ENDPOINT"; 
$user="admin"; 
$password="Password@123"; 
$db="studentdb"; 
$conn = new mysqli($host,$user,$password,$db); 
if($conn->connect_error){ 
die("Connection Failed"); 
} 
$firstname=$_POST['firstname']; 
$lastname=$_POST['lastname']; 
$email=$_POST['email']; 
$mobile=$_POST['mobile']; 
$gender=$_POST['gender']; 
$dob=$_POST['dob']; 
$course=$_POST['course']; 
$address=$_POST['address']; 
$pass=password_hash($_POST['password'], PASSWORD_DEFAULT); 
$sql="INSERT INTO students 
(firstname,lastname,email,mobile,gender,dob,course,address,password) 
VALUES 
('$firstname','$lastname','$email','$mobile','$gender','$dob','$course','$address','$pas
s')"; 
if($conn->query($sql)){ 
echo "<h2>Registration Successful!</h2>"; 
}else{ 
echo $conn->error; 
} 
$conn->close(); 
?>
