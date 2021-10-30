<?php session_start();
require_once "include.php";
if(!$_SESSION['loggedin']){
    Header("Location: login.php");
}

?>
    <?php
    $userid = $_SESSION['userid'];
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE ID=?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $balance = $row['balance'];
    $username = $row['Username'];

    ?>
<div class="container mt-4">
    <div class="row ms-3">
    <div class="card m-2" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Saldo</h5>
            <h6 class="card-subtitle mb-2 text-muted">Saldo: <strong><?=$balance?> CHF</strong></h6>
            <a href="addmoney.php" class="card-link">Geld aufladen</a>
        </div>
    </div>
    </div>
        <h2>Geld Aufladungen</h2>
     <?php
        $stmt = $conn->prepare("SELECT * FROM tbl_transaktionen WHERE User=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $betrag = $row['Betrag'];
            $neueSaldo = $row['NeueSaldo'];
            $Methode = $row['Methode'];
            ?>

            <p>Sie haben <b><?=$betrag?> CHF</b> per <b><?=$Methode?></b> auf Ihr Konto geladen. Neue Saldo: <b><?=$neueSaldo?> CHF</b></b></p>
        <?php
        }
        ?>

        <h2>Geld erhalten</h2>
        <?php
        $stmt = $conn->prepare("SELECT * FROM tbl_ueberweisungen WHERE EmpfaengerID=?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $senderid = $row['SenderID'];
            $datum = $row['Datum'];
            $betrag = $row['Betrag'];
            $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE ID=?");
            $stmt->bind_param("i", $senderid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $senderusername = $row['Username'];
            ?>
        <p>Sie haben <b><?=$betrag?> CHF</b> von <b><?=$senderusername?></b> am <b><?=$datum?> erhalten</b></b></p>
        <?php
        }
        ?>
        <h2>Geld versendet</h2>
        <?php
        $stmt = $conn->prepare("SELECT * FROM tbl_ueberweisungen WHERE SenderID=?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
            $empfaengerid = $row['SenderID'];
            $datum = $row['Datum'];
            $betrag = $row['Betrag'];
            $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE ID=?");
            $stmt->bind_param("i", $empfaengerid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $empfaengerusername = $row['Username'];
            ?>
            <p>Sie haben <b><?=$betrag?> CHF</b> an <b><?=$empfaengerusername?></b> am <b><?=$datum?></b> gesendet</p>
            <?php
        }
        ?>
    </div>