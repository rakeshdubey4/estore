<?php
include 'connection.php';
if(isset($_POST['submit-btn'])){
    $filter_name=filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name=mysqli_real_escape_string($conn, $filter_name);

    $filter_email=filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email=mysqli_real_escape_string($conn, $filter_email);

    $filter_password=filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password=mysqli_real_escape_string($conn, $filter_password);

    $filter_cpassword=filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
    $cpassword=mysqli_real_escape_string($conn, $filter_cpassword);
    $select_user= mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'") or die('query failed');

    if(mysqli_num_rows($select_user)>0){
        $message[]='user already exit';
    }
    else{
        if($password != $cpassword){
            $message[]='wrong password';
        }else{
            mysqli_query($conn, "INSERT INTO `users` (`name`, `email`, `password`) VALUES ('$name', '$email', '$password')") or die('query failed');
            $message[]='registered successfully';
            header('location:login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Register page</title>
</head>

<body>   
    <section class="form-container">
    <?php
   if(isset($message)){
    foreach($message as $message){
        echo '
             <div class="message">
                <span>'.$message.'</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
              </div>
        ';
    }
   }
   ?>
        <form method="post">
            <h1>login now</h1>
            <div class="input-field">
                <label>your email</label>
                <input type="email" name="email" placeholder="enter your email" required>
            </div>
            <div class="input-field">
                <label>your password</label>
                <input type="password" name="password" placeholder="enter your password" required>
            </div>
           
            <input type="submit" name="submit-btn" value="login now" class="btn">
            <p>do not have an account ? <a href="register.php">register now</a></p>
        </form>
    </section>
</body>

</html>