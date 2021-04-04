<?php
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
# connect
require '../database/database.php';
$pdo = Database::connect();
//if login.php is called using submit button, check user input
if (isset($_POST['create']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
    # 2. assign user info to a variable
    $email = $_POST['username'];
    $pass = $_POST['password'];
    $pass_hash = md5($pass);
    $pass_salt = password_hash($pass, PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    if ((strpos($email, "@") != false) && (strpos($email, ".com") != false)) {
        //(strlen($pass)>=16)
        if (isPartcase($pass) && specialChar($pass) && charAndNum($pass) && strlen($pass) >= 16) {
            # 3. assign MySQL query code to a variable
            $sql = 'insert into persons (email,password_hash,password_salt,role,fname,lname,phone,address,address2,city,state,zip_code) 
       values ("' . $_POST['username'] . '","' . $pass_hash . '","' . $pass_salt . '","' . $role . '","' . $fname . '","' . $lname . '","' . $phone . '","' . $address . '","' . $address2 . '","' . $city . '","' . $state . '","' . $zip . '")';
            # 4. insert the message into the database
            $pdo->query($sql); # execute the query
            header("Location: login.php");
        } else {
            $errMsg = 'Create failure: Password not formatted correctly.';
        }
    } else {
        $errMsg = 'Create failure: Email not formatted correctly.';
    }
} else {
    $errMsg = 'Create failure: Some data is empty.';
}
//else just siplay the input form.
//IE redisplay the html below.
if (isset($_POST['login'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
   <head>
      <title>New User</title>
      <meta charset="utf-8"/>
   </head>
   <body>
      <h1>CREATE NEW USER</h1>
      <h2>New user</h2>
      <form action="" method="post">
         Email <br>
         <input type="text" class="form-control"
            name="username" placeholder="admin@admin.com"
            autofocus />
         Password <br>
         <input type="password" class="form-control"
            name="password"  />
         Role<br>
         <select name="role" id="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
         </select>
         
         <br> First Name <br>
         <input type="text" class="form-control"
            name="fname"  />
         Last Name <br>
         <input type="text" class="form-control"
            name="lname"  />
         Phone Number <br>
         <input type="text" class="form-control"
            name="phone"  />
         Address <br>
         <input type="text" class="form-control"
            name="address" />
         Address 2 (Optional)<br>
         <input type="text" class="form-control"
            name="address2" />
         City <br>
         <input type="text" class="form-control"
            name="city"  />
         State <br>
         <input type="text" class="form-control"
            name="state"  />
         Zip <br>
         <input type="text" class="form-control"
            name="zip"  />
         <button class="btn btn-lg btn-primary btn-block"
            type="submit" name="create">Create</button>
         <button class="btn btn-lg btn-primary btn-block"
            type="submit" name="login">Login</button>
         <p style="color: red;"><?php echo $errMsg; ?></p>
      </form>
   </body>
</html>

