<div class="container mt-4">
<?php session_start();
require_once "dbconn.php";
require_once "bootstrap.php";
global $conn;

if (isset( $_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE Username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $pw = $row['Password'];
    $isAdmin = $row['isAdmin'];
    $userid = $row['ID'];
    if (password_verify($password, $pw)){
        if ($isAdmin == 1) {
            echo "<div class='alert alert-success'>Willkommen $username</div>";
            echo '<script>
setTimeout(function (){
    window.location.href = "dashboardadmin.php";
}, 2000);
</script>';
            $_SESSION['loggedin'] = true;
            $_SESSION['isAdmin'] = true;
            $_SESSION['userid'] = $userid;
        } else {
            echo "<div class='alert alert-success'>Willkommen $username</div>";
            echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 2000);
</script>';
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $userid;
        }
    } else {
        echo "<div class='alert alert-danger'>Es gab ein fehler beim einloggen. Versuchen Sie es erneut oder erstellen Sie einen neuen User falls sie noch keine haben <a href='registrieren.php'>hier</a></div>";
    }
}
?>

    <div class="form">
        <form method="post">
            <h2>Einloggen</h2>
            <br>
            <input class="form-control mb-3" type="text" name="username" placeholder="Benutzername" required>

            <input class="form-control mb-3" type="password" name="password" placeholder="Passwort" required>

            <input class="btn btn-primary mb-3" type="submit" name="submit" value="Einloggen">
        </div>
    </div>
