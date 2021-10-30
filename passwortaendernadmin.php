<?php session_start();
require_once "includeadmin.php";
require_once "navbaradmin.php";
?>
<div class="container mt-4">
    <?php
    if (!$_SESSION['loggedin']) {
        header("Location: login.php");
    }
    if(!$_SESSION['isAdmin']){
        Header("Location: login.php");
    }
    if (isset($_POST['submit'])){
        $altespasswort = $_POST['altespasswort'];
        $neuespasswort = $_POST['neuespasswort'];
        $neuespasswort = password_hash($neuespasswort, PASSWORD_DEFAULT);


        $userid = $_SESSION['userid'];
        $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE ID=?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $pw = $row['Password'];
        if (password_verify($altespasswort, $pw)){
            $stmt = $conn->prepare("UPDATE tbl_users SET Password=? WHERE ID=?");
            $stmt->bind_param("si", $neuespasswort, $userid);
            if ($stmt->execute()){
                echo "<div class='alert alert-success'> Das Passwort wurde erfolgreich geändert </div>";
                echo '<script>
                     
setTimeout(function () {
    window.location.href = "logout.php";
}, 2000);
                    
</script>';
            }
        }else{
            echo "<div class='alert alert-danger'>Das Passwort ist nicht korrekt </div>";
            echo '<script>
                     
setTimeout(function () {
    window.location.href = "passwortaendernadmin.php";
}, 2000);
                    
</script>';
        }
    }
    ?>

    <form method="post">
        <h2>Passwort ändern</h2>
        <br>
        <input class="form-control" type = "text" name = "altespasswort" placeholder="Altes Passwort" required><br>
        <input class="form-control" type = "text" name = "neuespasswort" placeholder="Neues Passwort" required><br>
        <input class="btn btn-primary" type = "submit" name="submit" value="Registrieren">
    </form>
</div>
</div>

