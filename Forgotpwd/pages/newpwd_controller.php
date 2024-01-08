<?php
if (isset($_POST["resetpwd"])) {
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $passwordRepeat = filter_input(INPUT_POST, "c_password", FILTER_SANITIZE_SPECIAL_CHARS);

    $selector = $_POST["selector"];
    $validator = hex2bin($_POST["validator"]);
    $actualDate = date("U");
    if (empty($password) || empty($passwordRepeat)) {
        echo "password is empty";
        exit;
    } else if ($password !== $passwordRepeat) {
        echo "the passwords is not the same";
        exit;
    }

        // Vérifier l'existence du lien dans la base de données
    $currentDate = date("U");
    $result = $db->query("SELECT * FROM passwordrecovery WHERE pwd_reset_selector = ? AND pwd_reset_expires >= ?");
    $db->bind(1, $selector);
    $db->bind(2, $currentDate);
    $row = $db->single();

    if ($row) {
        // Lien valide, traiter la soumission du formulaire
        if (isset($_POST['resetpwd'])) {
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['c_password'];

            // Vérifier si les mots de passe correspondent
            if ($newPassword === $confirmPassword) {
                // Mettez à jour le mot de passe dans la base de données (assurez-vous d'utiliser des méthodes de hachage sécurisées)
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $db->query("UPDATE users SET password = ? WHERE user_id = ?");
                $db->bind(1, $hashedPassword);
                $db->bind(2, $row['user_id']);
                $db->execute();

                // Supprimer l'entrée correspondante dans la table passwordrecovery
                $db->query("DELETE FROM passwordrecovery WHERE pwd_reset_selector = ?");
                $db->bind(1, $selector);
                $db->execute();

                // Rediriger vers la page de connexion
                header("Location: index.php?page=login&password=changed");
                exit();
            } else {
                // Les mots de passe ne correspondent pas, afficher un message d'erreur si nécessaire
                echo "Passwords do not match";
                exit();
            }
        } else {
            // Si la soumission du formulaire n'est pas détectée, ne rien faire ici
        }
    } else {
        // Lien invalide ou expiré
        echo "Invalid token or expired link";
        exit();
    }
}


















//
//<?php
//// Vérifier si les paramètres du lien sont présents dans l'URL
//if (isset($_GET["selector"]) && isset($_GET["token"])) {
//    $selector = $_GET["selector"];
//    $token = $_GET["token"];
//
//    // Vérifier l'existence du lien dans la base de données
//    $currentDate = date("U");
//    $result = $db->query("SELECT * FROM passwordrecovery WHERE pwd_reset_selector = ? AND pwd_reset_expires >= ?");
//    $db->bind(1, $selector);
//    $db->bind(2, $currentDate);
//    $row = $db->single();
//
//    // ...
//    if ($row) {
//        // Lien valide, traiter la soumission du formulaire
//        if (isset($_POST['resetpwd'])) {
//            $newPassword = $_POST['password'];
//            $confirmPassword = $_POST['c_password'];
//
//            // Vérifier si les mots de passe correspondent
//            if ($newPassword === $confirmPassword) {
//                // Mettez à jour le mot de passe dans la base de données (assurez-vous d'utiliser des méthodes de hachage sécurisées)
//                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
//                $db->query("UPDATE users SET password = ? WHERE user_id = ?");
//                $db->bind(1, $hashedPassword);
//                $db->bind(2, $row['user_id']);
//                $db->execute();
//
//                // Supprimer l'entrée correspondante dans la table passwordrecovery
//                $db->query("DELETE FROM passwordrecovery WHERE pwd_reset_selector = ?");
//                $db->bind(1, $selector);
//                $db->execute();
//
//                // Rediriger vers la page de connexion
//                header("Location: index.php?page=login");
//                exit();
//            } else {
//                // Les mots de passe ne correspondent pas, afficher un message d'erreur si nécessaire
//                echo "Passwords do not match";
//                exit();
//            }
//        } else {
//            // Si la soumission du formulaire n'est pas détectée, ne rien faire ici
//        }
//    } else {
//        // Lien invalide ou expiré
//        echo "Invalid token or expired link";
//        exit();
//    }
//}
