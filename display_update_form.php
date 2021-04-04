<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
if ($_SESSION['role'] != "admin" && $_SESSION['id'] != $_GET['id']) {
    header("Location: display_list.php");
}
# connect
require '../database/database.php';
$pdo = Database::connect();
# put the information for the chosen record into variable $results
$id = $_GET['id'];
$sql = "SELECT * FROM persons WHERE id=" . $id;
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
foreach ($pdo->query($sql) as $row) {
    //couldn't figure out how else to interact outside of loop
    $email = $row['email'];
    $role = $row['role'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $pass_hash = $row['password_hash'];
    $pass_salt = $row['password_salt'];
    $phone = $row['phone'];
    $address = $row['address'];
    $address2 = $row['address2'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip_code'];
}
//----------------------------------------------------------------------
function isPartcase($word) {
    if (strtolower($word) != $word && strtoupper($word) != $word) {
        return true;
    } else {
        return false;
    }
}
function specialChar($word) {
    $specialChar = array('!', '@', '#', '$', '%', '^', '&', '*', '-', '_', '+', ' ');
    foreach ($specialChar as $x) {
        if (strpos($word, $x)) {
            return true;
        }
    }
    return false;
}
function charAndNum($word) {
    if (preg_match('/[A-Za-z]/', $word) && preg_match('/[0-9]/', $word)) {
        return true;
    } else {
        return false;
    }
}
$errMsg = "";
//if login.php is called using submit button, check user input
if (isset($_POST['submitChange'])) {
    # 2. assign user info to a variable
    $shouldIUpdate = true;
    //looks to see if the box's are empty if they are it will not over write
    //the data that is already in the database.
    if (empty($_POST['role']) == 0) {
        $role = $_POST['role'];
    }
    if (empty($_POST['fname']) == 0) {
        $fname = $_POST['fname'];
    }
    if (empty($_POST['lname']) == 0) {
        $lname = $_POST['lname'];
    }
    if (empty($_POST['phone']) == 0) {
        $phone = $_POST['phone'];
    }
    if (empty($_POST['address']) == 0) {
        $address = $_POST['address'];
    }
    if (empty($_POST['address2']) == 0) {
        $address2 = $_POST['address2'];
    }
    if (empty($_POST['city']) == 0) {
        $city = $_POST['city'];
    }
    if (empty($_POST['state']) == 0) {
        $state = $_POST['state'];
    }
    if (empty($_POST['zip']) == 0) {
        $zip = $_POST['zip'];
    }
    if ($_POST['username'] != "") {
        if (strpos($email, "@") != false && (strpos($email, ".com") != false)) {
            $email = $_POST['username'];
        } else {
            $shouldIUpdate = false;
        }
    }
    if ($_POST['password'] != "") {
        if (isPartcase($pass) && specialChar($pass) && charAndNum($pass) && strlen($pass) >= 16) {
            $pass = $_POST['password'];
            $pass_hash = md5($pass);
            $pass_salt = password_hash($pass, PASSWORD_DEFAULT);
        } else {
            $shouldIUpdate = false;
        }
    }
    if ($shouldIUpdate) {
        # 3. assign MySQL query code to a variable
        $sql = "UPDATE persons SET 
       role = '" . $role . "',
       fname = '" . $fname . "',
       lname = '" . $lname . "',
       email = '" . $email . "',
       phone = '" . $phone . "',
       password_hash = '" . $pass_hash . "',
       password_salt = '" . $pass_salt . "',
       address = '" . $address . "',
       address2 = '" . $address2 . "',
       city = '" . $city . "',
       state = '" . $state . "',
       zip_code = '" . $zip . "' 
       WHERE id = '" . $id . "'";
        # 4. insert the message into the database
        $pdo->query($sql); # execute the query
        header("Location: https://cps355dap.000webhostapp.com/As16/display_list.php");
    }
}
if (isset($_POST['back'])) {
    header("Location: display_list.php ");
}
//else just siplay the input form.
//IE redisplay the html below.

?>
<!DOCTYPE html>
<html lang="en-US">
    <h1>Update Existing User</h1>
   <head>
      <title>Update User</title>
      <meta charset="utf-8"/>
   </head>
   <body>
      <h2>New user</h2>
      <form action="" method="post">
         Email <br>
         <input type="text" class="form-control"
            name="username" placeholder="<?=$email?>"
            autofocus /> <br /><br />
         Password <br>
         <input type="password" class="form-control"
            name="password"  /> <br /><br />
          Role<br>
         <?php
if ($_SESSION['id'] != $row['id']) {
    echo '<select name="role" id="role">
            <option value=""></option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
         </select>';
}else {
    echo '<select name="role" id="role" disabled>
            <option value=""></option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
            </select>';
}
?>
        
         
         <br><br>
         First Name <br>
         <input type="text" class="form-control"
            name="fname"  placeholder="<?=$fname
?>"/> <br /><br />
         Last Name <br>
         <input type="text" class="form-control"
            name="lname"  placeholder="<?=$lname
?>"/> <br /><br />
         Phone Number <br>
         <input type="text" class="form-control"
            name="phone"  placeholder="<?=$phone?>"/> <br /><br />
         Address <br>
         <input type="text" class="form-control"
            name="address"  placeholder="<?=$address?>"/> <br /><br />
         Address 2 (Optional)<br>
         <input type="text" class="form-control"
            name="address2"  placeholder="<?=$address2?>"/> <br /><br />
         City <br>
         <input type="text" class="form-control"
            name="city"  placeholder="<?=$city?>"/> <br /><br />
         State <br>
         <input type="text" class="form-control"
            name="state" placeholder="<?=$state?>"/> <br /><br />
         Zip <br>
         <input type="text" class="form-control"
            name="zip" placeholder="<?=$zip?>"  /> <br /><br />
         <button class="btn btn-lg btn-primary btn-block"
            type="submit" name="submitChange">Submit Change</button>
            <button class="btn btn-lg btn-primary btn-block"
            type="submit" name="back">Back to Menu</button>
      </form>
   </body>
</html>