<div class="container mt-4">
<?php require_once "dbconn.php";
require_once "bootstrap.php";
global $conn;

if (isset($_POST['submit'])) {
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $stmt = $conn->prepare ("SELECT * FROM tbl_users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>Der gewählte Username ist bereits vergeben, falls du bereits ein Konto besitzt, kannst du dich <a href='login.php'>hier</a> anmelden</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_users (Vorname, Nachname, Username, Password, Email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $vorname, $nachname, $username, $password, $email);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Herzlich Willkommen $username. Du wurdest erfolgreich Registriert!</div>";

            echo '<script>
setTimeout(function () {
    window.location.href = "login.php";
}, 2000);
</script>';
        } else {
            echo "<div class='alert alert-danger'>Es gab einen fehler beim Registrieren</div>";

            echo '<script>
setTimeout(function () {
    window.location.href = "registrieren.php";
}, 2000);
</script>';
        }

    }
}
?>

<div class="form">
    <form method="post">

    <h2>Registrieren</h2>
        <br>
            <input class="form-control mb-3" type="text" name="vorname" placeholder="Vorname" required>


            <input class="form-control mb-3" type="text" name="nachname" placeholder="Nachname" required>


            <input class="form-control mb-3" type="text" name="username" placeholder="Benutzername" required>

            <input class="form-control mb-3" type="password" name="password" placeholder="Passwort" required>


            <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>

            <input class="btn btn-primary mb-3" type="submit" name="submit" value="Registrieren">
        </div>
    </form>
</div>
</div>

