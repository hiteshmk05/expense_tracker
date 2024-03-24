<?php 


    include('dbConfig.php');

    $msg="";

    if (isset($_REQUEST['register'])) {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($result) > 0) {
            $msg="Username already registered!";
        } else {
            mysqli_query($conn, "INSERT INTO users(username, password) VALUES('$username', '$password')");
            $msg="Registration successful!";
        }
    }


?>



<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Sign up form</title>
    <link rel="stylesheet" href="loginPage.css">
</head>

<body>
    <div class="container">
        <form class="form form--hidden" id="createAccount" action="" method="post">
            <h1 class="form__title">Create Account</h1>
            <div class="form__message form__message--error"><h4><?php echo "$msg"; ?></h4></div>
            <div class="form__input-group">
                <input type="text" id="signupUsername" class="form__input" autofocus placeholder="Username"
                    name="username" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="email" class="form__input" autofocus placeholder="Email Address" name="email_id" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" autofocus placeholder="Password" name="password" required>
                <div class="form__input-error-message"></div>
            </div>
            <button class="form__button" type="submit" name="register">Continue</button>
            <p class="form__text">
                Already have an account? 
                <a class="form__link" href="signin.php">Sign in</a>
            </p>
        </form>
    </div>
</body>

</html>