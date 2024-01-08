<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if (isset($_POST["forgotpwd"])) {
    $email = $_POST["email"];

    $result = $db->query("SELECT * FROM users WHERE email = ?");
    $db->bind(1, $email);
    $user = $db->single();

    if ($user) {
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $expires = date("U") + 3600;

        $db->query("INSERT INTO passwordrecovery (pwd_reset_email, pwd_reset_selector, pwd_reset_token, pwd_reset_expires, user_id) VALUES (?, ?, ?, ?, ?)");
        $db->bind(1, $email);
        $db->bind(2, $selector);
        $db->bind(3, $token);
        $db->bind(4, $expires);
        $db->bind(5, $user['user_id']);
        $db->execute();

        $resetLink = "http://localhost/Maryam_Jammar_Alpha/index.php?page=newpwd&selector=" . $selector . "&validator=" . bin2hex($token);

        $to = $email;
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: maryamjr03@gmail.com"; // Remplacez par votre adresse e-mail


        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'maryamjr03@gmail.com';
        $mail->Password = 'qcda lxlm cvxv wqja';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('maryamjr03@gmail.com', 'maryam');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "$message";

        $mail->send();
//        header("Location: index.php?page=login");
        echo 'Message has been sent';
        exit();
    } else {
        echo "Email not found";
    }



}

