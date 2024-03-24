<?php 


    include('dbConfig.php');

    $msg="";
  
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $sql = mysqli_query($conn,"select * from users where username='$email' && password='$password'");
        $num=mysqli_num_rows($sql);
        if ($num>0) {
            $row=mysqli_fetch_assoc($sql);
            $_SESSION['USER_ID']=$row['id'];
            $_SESSION['USER_NAME']=$row['username'];
            header("location:dashboard.php");
        }
        else{
            $msg="Please Enter Valid Details !";
        }
    }


?>


<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Sign in form</title>
    <link rel="stylesheet" href="loginPage.css">
</head>

<body>
    <div class="container">
        <form action="" method="POST" class="form" id="login">
            <h1 class="form__title">Login</h1>
            <div class="form__message form__message--error"><h4><?php echo "$msg"; ?></h4></div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus placeholder="username" name="username" id="username">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" autofocus placeholder="Password" name="password" id="password">
                <div class="form__input-error-message"></div>
            </div>
            <button type="submit" name="submit" id="submit" class="form__button">Continue</button>
            <p class="form__text">
            Don't have an account? 
                <a class="form__link" href="signup.php">Create account</a>
            </p>
        </form>
    </div>
</body>

</html>