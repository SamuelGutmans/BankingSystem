<?php session_start();
require_once "includeadmin.php";
if(!$_SESSION['loggedin']){
    Header("Location: login.php");
}
if(!$_SESSION['isAdmin']){
    Header("Location: login.php");
}
?>
    <div class="container mt-4">
        <h1>Log</h1>
        <br>
        <h3>Überweisungen</h3>
        <?php
$result = $conn->query("SELECT * FROM tbl_ueberweisungen");
while ($row = $result->fetch_assoc()) {
    $ID = $row['ID'];
    $senderID = $row['SenderID'];
    $empfaengerID = $row['EmpfaengerID'];
    $betrag = $row['Betrag'];
    $datum = $row['Datum'];
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE ID=?");
    $stmt->bind_param("i", $senderID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $senderusername = $row['Username'];
    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE ID=?");
    $stmt->bind_param("i", $empfaengerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $empfaengerusername = $row['Username'];
    ?>
    <p><b><?=$senderusername?></b> hat <b><?=$empfaengerusername?> <?=$betrag?> CHF</b> am <b><?=$datum?></b> überwiesen!</p>
    <br>
<?php
}
?>
    <h3>Geldaufladungen</h3>
    <?php
    $result = $conn->query("SELECT * FROM tbl_transaktionen");
    while ($row = $result->fetch_assoc()) {
        $username = $row['User'];
        $betrag = $row['Betrag'];
        $neueSaldo = $row['NeueSaldo'];
        $methode = $row['Methode'];

    ?>
        <p><b><?=$username?></b> hat <b><?=$betrag?> CHF</b> auf sein Konto geladen per <b><?=$methode?></b> sein neues Saldo beträgt <b><?=$neueSaldo?> CHF!</b></p>

<?php
}
?>
    </div>
