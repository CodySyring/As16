<?php
# This process del a record. There is no display.
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
if ($_SESSION['role'] != "admin") {
    header("Location: display_list.php");
}
//set session id
$id = $_GET['id'];
//get connected to database
require '../database/database.php';
$pdo = Database::connect();
if (isset($_POST['no'])) {
    header("Location: display_list.php");
}
if (isset($_POST['yes'])) {
    $sql = "DELETE FROM persons WHERE id=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    $pdo->query($sql); # execute the query
    header("Location: display_list.php");
}
# 2. assign user info to a variable
$sql = "SELECT * FROM persons WHERE id=" . $id;
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
foreach ($pdo->query($sql) as $row) {
    echo ("<h1> Do you want to delete: " . $row['fname'] . " " . $row['lname'] . "<br></h1>");
}
#3 sql to delete a record

?>
<html>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <form action="" method="post">
    <button class="btn btn-lg btn-primary btn-block"
    type="submit" name="yes">Delete</button>
                
    <button class="btn btn-lg btn-primary btn-block"
    type="submit" name="no">Abort</button>
    </form>
</html>