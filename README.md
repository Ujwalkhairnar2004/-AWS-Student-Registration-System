# -AWS-Student-Registration-System
A simple Student Registration Web Application deployed on AWS EC2 using Nginx + PHP, with Amazon RDS MySQL as the backend database.

🚀 Project Overview

This project demonstrates how to deploy a dynamic PHP website on AWS.

🛠️ Technologies Used
AWS EC2
Amazon RDS MySQL
Nginx
PHP
PHP-FPM
MySQL
HTML5
CSS3
Linux
Git & GitHub

📁 Project Structure
student-registration/
│
├── index.html
├── insert.php
└── README.md

☁️ AWS EC2 Setup
1. Launch EC2

Recommended configuration:

AMI: Amazon Linux 2023
Instance Type: t2.micro
HTTP: Port 80
SSH: Port 22
SSH source: Your IP

Connect to EC2:

ssh -i your-key.pem ec2-user@EC2_PUBLIC_IP
2. Install Nginx
sudo dnf update -y
sudo dnf install nginx -y

Enable and start Nginx:

sudo systemctl enable nginx
sudo systemctl start nginx
sudo systemctl status nginx

Test:

http://EC2_PUBLIC_IP
3. Install PHP
sudo dnf install php php-fpm php-mysqlnd -y

Start PHP-FPM:

sudo systemctl enable php-fpm
sudo systemctl start php-fpm

Check PHP:

php -v
4. Configure Nginx

Edit:

sudo nano /etc/nginx/nginx.conf

Configure PHP:

location / {
    index index.html index.php;
}

location ~ \.php$ {
    root /usr/share/nginx/html;

    fastcgi_pass unix:/run/php-fpm/www.sock;
    fastcgi_index index.php;

    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}

Test configuration:

sudo nginx -t

Restart:

sudo systemctl restart nginx
sudo systemctl restart php-fpm
🗄️ Amazon RDS MySQL

Create an RDS MySQL database with:

Engine: MySQL
Database: studentdb
Username: admin

After creating RDS, copy the RDS endpoint.

Example:

studentdb.xxxxx.ap-south-1.rds.amazonaws.com

⚠️ Never upload your real database password or credentials to GitHub.

🔐 RDS Security Group

Allow MySQL traffic:

Type: MySQL/Aurora
Port: 3306
Source: EC2 Security Group

Do not use 0.0.0.0/0 for MySQL in a production environment.

🔌 Connect EC2 to RDS

Install MySQL/MariaDB client:

sudo dnf install mariadb105 -y

Connect:

mysql -h YOUR-RDS-ENDPOINT -u admin -p
🗃️ Create Database
CREATE DATABASE studentdb;

USE studentdb;

Create the students table:

CREATE TABLE students(
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    email VARCHAR(100),
    mobile VARCHAR(20),
    gender VARCHAR(20),
    dob DATE,
    course VARCHAR(50),
    address TEXT,
    password VARCHAR(255)
);
🌐 Website

The website contains a Student Registration Form with:

First Name
Last Name
Email
Mobile Number
Gender
Date of Birth
Course
Address
Password
Confirm Password

The form sends data to:

insert.php
📄 index.html

The frontend is stored at:

/usr/share/nginx/html/index.html

The form uses:

<form action="insert.php" method="POST">
📄 insert.php

Create:

sudo nano /usr/share/nginx/html/insert.php

Example:

<?php

$host = "YOUR-RDS-ENDPOINT";
$user = "admin";
$password = "YOUR-PASSWORD";
$db = "studentdb";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection Failed");
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$course = $_POST['course'];
$address = $_POST['address'];

$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO students
(firstname, lastname, email, mobile, gender, dob, course, address, password)
VALUES
('$firstname', '$lastname', '$email', '$mobile', '$gender', '$dob', '$course', '$address', '$pass')";

if ($conn->query($sql)) {
    echo "<h2>Registration Successful!</h2>";
} else {
    echo $conn->error;
}

$conn->close();

?>

Replace:

YOUR-RDS-ENDPOINT

with your actual RDS endpoint.

🔒 File Permissions
sudo chmod 644 /usr/share/nginx/html/index.html
sudo chmod 644 /usr/share/nginx/html/insert.php

Restart services:

sudo systemctl restart php-fpm
sudo systemctl restart nginx
🧪 Test Application

Open your browser:

http://EC2_PUBLIC_IP

Fill out the registration form and click:

Register Now
🔍 Verify Database

Connect to RDS:

mysql -h YOUR-RDS-ENDPOINT -u admin -p

Then:

USE studentdb;

SELECT * FROM students;

You should see the submitted student records.

📊 Project Flow
User
  |
  ↓
Student Registration Form
  |
  ↓
Nginx
  |
  ↓
PHP-FPM
  |
  ↓
insert.php
  |
  ↓
Amazon RDS MySQL
  |
  ↓
students table
🎯 Learning Outcomes

Through this project, you can learn:

How to launch an EC2 instance
How to install and configure Nginx
How to install PHP and PHP-FPM
How to configure Nginx with PHP
How to create an Amazon RDS MySQL database
How to connect EC2 with RDS
How to configure AWS Security Groups
How to deploy a PHP application on AWS
How to store form data in MySQL
How to verify application data from the database
🔐 Security Notes

For a real production application:

Never commit passwords to GitHub.
Store database credentials in environment variables or AWS Secrets Manager.
Use HTTPS/SSL.
Restrict SSH access to trusted IP addresses.
Allow RDS port 3306 only from the EC2 security group.
Use prepared SQL statements to prevent SQL injection.
Do not expose the RDS database directly to the internet.
👨‍💻 Author

Your Name

AWS Cloud / DevOps Project

⭐ If you found this project useful, consider giving the repository a star!
