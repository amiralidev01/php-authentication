PHP Authentication System

A simple and secure user authentication system built with PHP and MySQL.
This project includes all the core features of a login/register system, plus password recovery via email.

✨ Features

User Registration (Sign Up)

User Login

Secure Password Hashing (password_hash / password_verify)

Forgot Password (Send reset link via email)

Password Reset with unique token

User Logout

Simple and clean code structure (easy to extend)

🛠 Requirements

PHP 7.4 or higher

MySQL / MariaDB

Enabled PHP extensions: openssl, mbstring

Local server environment (XAMPP, Laragon, WAMP, etc.)

🚀 Installation

Clone the repository:

git clone git@github.com:amiralidev01/php-authentication.git
cd php-authentication


Create a database (e.g., auth_system) and import the provided database.sql.

Configure database connection inside config.php:

$host = "localhost";
$dbname = "auth_system";
$username = "root";
$password = "";


Configure email settings inside mailer.php:

$mail->Host       = 'smtp.example.com';
$mail->Username   = 'you@example.com';
$mail->Password   = 'yourpassword';
$mail->setFrom('you@example.com', 'Auth System');


Start your local server and open:

http://localhost/php-authentication

📂 Project Structure
php-authentication/
│-- config.php          # Database configuration
│-- register.php        # User registration
│-- login.php           # User login
│-- logout.php          # User logout
│-- forgot_password.php # Request reset link
│-- reset_password.php  # Reset form
│-- mailer.php          # Email sender (PHPMailer)
│-- database.sql        # Database schema

📧 Password Reset Flow

1-User submits email in Forgot Password form.

2-A unique token is generated and stored in DB.

3-An email with reset link (reset_password.php?token=...) is sent.

4-User clicks link, sets a new password.

5-Password is updated securely in DB.
