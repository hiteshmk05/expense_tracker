<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $to = "arunabhshikhar11@gmail.com"; 
        $subject = "Contact Us Form Submission from $name";
        $headers = "From: $email";
        mail($to, $subject, $message, $headers);
        echo "Thank you for your message! We will get back to you soon.";
    }
?>