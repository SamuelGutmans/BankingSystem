<?php session_start();
require_once "include.php";
require_once "navbaruser.php";?>
<div class="container mt-4">
    <?php
    if(!$_SESSION['loggedin']){
        Header("Location: login.php");
    }
    if(isset($_POST['submit'])) {
        $userid = $_SESSION['userid'];
        $senderid = $userid;
        $amount = $_POST['amount'];
        $empfaengeremail = $_POST['empfaenger'];
        $grund = $_POST['grund'];
        date_default_timezone_set("Europe/Berlin");
        $timestamp = time();
        $datum = date("Y.m.d", $timestamp);
        $stmt = $conn->prepare("SELECT * FROm tbl_users WHERE ID=?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $balancesender = $row['balance'];
        if ($balancesender > $amount) {
            $Username = $row['Username'];
            $newbalancesender = $balancesender - $amount;
            $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE Email=?");
            $stmt->bind_param("s", $empfaengeremail);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $empfaengerid = $row['ID'];
                $stmt = $conn->prepare("UPDATE tbl_users SET balance=balance-? WHERE ID=?");
                $stmt->bind_param("si", $amount, $senderid);
                $stmt2 = $conn->prepare("UPDATE tbl_users SET balance=balance+? WHERE ID=?");
                $stmt2->bind_param("si", $amount, $empfaengerid);
                if ($stmt->execute() && $stmt2->execute()) {
                    $stmt = $conn->prepare("INSERT INTO tbl_ueberweisungen (SenderID, EmpfaengerID, Grund, Datum, Betrag) VALUES (?,?,?,?,?)");
                    $stmt->bind_param("sssss", $senderid, $empfaengerid, $grund, $datum, $amount);
                    $stmt->execute();
                    echo "<div class='alert alert-success'>Ihr Saldo wurde erfolgreich geupdatet</div>";
                    echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 20000);
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
                echo "<div class='alert alert-danger'>Es gibt keine Benutzer mit der angegebenen E-Mail Adresse</div>";
                echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 2000);
</script>';
            }
        } else {
            echo "<div class='alert alert-danger'>Dein Saldo reicht für diese Überweisung nicht aus. Lade bitte Geld auf</div>";
            echo '<script>
setTimeout(function (){
    window.location.href = "dashboard.php";
}, 2000);
</script>';
        }
    }
    ?>
    <h2>Geld senden</h2>
    <form method="post">
        <label>E-Mail</label>
        <input class="form-control mb-3" type="text" name="empfaenger" placeholder="E-mail" required>
        <label>Betrag</label>
        <input class="form-control mb-3" type="text" name="amount" placeholder="Betrag" required>
        <div class="form-group">
            <label>Kommentar</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="grund" placeholder="Kommentar zur Überweisung"required></textarea>
        </div>
        <input class="btn btn-primary mb-3" type="submit" name="submit" value="Senden">
    </form>
</div>

