<?php session_start();
require_once "include.php";
require_once "navbaruser.php";?>
<div class="container mt-4">
    <?php
if(!$_SESSION['loggedin']){
    Header("Location: login.php");
}
if(isset($_POST['add'])) {
    $userid = $_SESSION['userid'];
    $amount = $_POST['amount'];
    if ($amount > 0) {
        $method = $_POST['method'];
        $stmt = $conn->prepare("SELECT * FROm tbl_users WHERE ID=?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $balance = $row['balance'];
        $Username = $row['Username'];
        $newbalance = $balance + $amount;
        $stmt = $conn->prepare("UPDATE tbl_users SET balance=? WHERE ID=?");
        $stmt->bind_param("ii", $newbalance, $userid);
        if ($stmt->execute()) {
            $stmt = $conn->prepare("INSERT INTO tbl_transaktionen (User, Betrag, NeueSaldo, Methode) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $Username, $amount, $newbalance, $method);
            $stmt->execute();
            echo "<div class='alert alert-success'>Das Geld wurde erfolgreich gesendet</div>";
            echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 2000);
</script>';
        } else {
            echo "<div class='alert alert-danger'>Es gab ein Fehler beim hinzufügen des Geldes. Bitte versuchen Sie es später erneut</div>";
            echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 2000);
</script>';
        }
    } else {
        echo "<div class='alert alert-danger'>Bitte überprüfen Sie Ihre Eingabe</div>";
        echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 2000);
</script>';
    }
}
?>
    <h2>Geld aufladen</h2>
    <form method="post">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Methode auswählen</label>
            <select class="form-control" id="exampleFormControlSelect1" name="method">
                <option>-</option>
                <option>Bank</option>
                <option>Kreditkarte</option>
            </select>
        </div>
        <label>Betrag</label>
        <input class="form-control mb-3" type="text" name="amount" placeholder="Betrag" required>
        <input class="btn btn-primary mb-3" type="submit" name="add" value="Add">
    </form>
</div>
