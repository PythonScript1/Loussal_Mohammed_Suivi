<?php
if (file_exists("models/User.php"))
    include_once "models/User.php";

$user = new User();
global $row;
if(isset($_POST['signin'])){
    extract($_POST);
    echo $email;
    try {
        if ($row = $user->login($email, $password)) {
            $_SESSION["signin"] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['picture'] = $row['picture'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
            header("Location: index.php?page=dashboard");
        }
    } catch (Exception $e) {
        header("Location: index.php?error={$e->getMessage()}&&page=signin");
    }


}