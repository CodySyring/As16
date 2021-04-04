<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
echo "<h1>Messages List</h1>";
# connect
require '../database/database.php';
$pdo = Database::connect();
# display link to "create" form
echo "<a href='new_user.php'>Create </a>";
#display link to logout app and forward to logout.php
echo "<a href='logout.php'>Logout</a><br><br>";
# display all records
$sql = 'SELECT * FROM persons';
if ($_SESSION['role'] == "admin") {
    //if admin
    $tableHold = "<table><tr>
                <th>Options</th>
                <th>ID</th>
                <th>Role</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password hash</th>
                <th>Password salt</th>
                <th>Address</th>
                <th>Address2</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
            <tr>";
    if (isset($_POST['update'])) {
        echo "madeit";
    }
    foreach ($pdo->query($sql) as $row) {
        $str = "<tr>";
        $str.= "<td>";
        $str.= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
        if ($_SESSION['id'] != $row['id']) {
            $str.= "<a href='display_delete_form.php?id=" . $row['id'] . "'>Delete</a></td>";
        }
        $str.= '<td>' . $row['id'] . '</td>';
        $str.= '<td>' . $row['role'] . '</td>';
        $str.= '<td>' . $row['fname'] . '</td>';
        $str.= '<td>' . $row['lname'] . '</td>';
        $str.= '<td>' . $row['email'] . '</td>';
        $str.= '<td>' . $row['phone'] . '</td>';
        $str.= '<td>' . $row['password_hash'] . '</td>';
        $str.= '<td>' . $row['password_salt'] . '</td>';
        $str.= '<td>' . $row['address'] . '</td>';
        $str.= '<td>' . $row['address2'] . '</td>';
        $str.= '<td>' . $row['city'] . '</td>';
        $str.= '<td>' . $row['state'] . '</td>';
        $str.= '<td>' . $row['zip_code'] . '</td>';
        $str.= '</tr>';
        $tableHold.= $str;
    }
    $tableHold.= "</table>";
    echo ($tableHold);
    echo '<br />';
} else {
    //if not admin
    $tableHold = "<table><tr>
                <th>Options</th>
                <th>ID</th>
                <th>Role</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password hash</th>
                <th>Password salt</th>
                <th>Address</th>
                <th>Address2</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
            <tr>";
    foreach ($pdo->query($sql) as $row) {
        $str = "<tr>";
        $str.= "<td>";
        if ($_SESSION['id'] == $row['id']) {
            $str.= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
            $str.= "<a href='display_delete_form.php?id=" . $row['id'] . "'>Delete</a>";
        }
        $str.= "</td>";
        $str.= '<td>' . $row['id'] . '</td>';
        $str.= '<td>' . $row['role'] . '</td>';
        $str.= '<td>' . $row['fname'] . '</td>';
        $str.= '<td>' . $row['lname'] . '</td>';
        $str.= '<td>' . $row['email'] . '</td>';
        $str.= '<td>' . $row['phone'] . '</td>';
        $str.= '<td>' . $row['password_hash'] . '</td>';
        $str.= '<td>' . $row['password_salt'] . '</td>';
        $str.= '<td>' . $row['address'] . '</td>';
        $str.= '<td>' . $row['address2'] . '</td>';
        $str.= '<td>' . $row['city'] . '</td>';
        $str.= '<td>' . $row['state'] . '</td>';
        $str.= '<td>' . $row['zip_code'] . '</td>';
        $str.= '</tr>';
        $tableHold.= $str;
    }
    $tableHold.= "</table>";
    echo ($tableHold);
    echo '<br />';
}
?>

<html>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <head>
        <style>
        table, th, td {
          border: 1px solid black;
          padding: 15px;
        }
        </style>
    </head>
<body>