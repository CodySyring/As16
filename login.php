<?php
session_start();
$errMsg = '';
$pass = '';
# connect
require '../database/database.php';
$pdo = Database::connect();
//if login.php is called using submit button, check user input
if (isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = 'SELECT * FROM persons WHERE email = "' . $_POST['email'] . '"';
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();
    $pass = MD5($_POST['password']);
    if ($result['password_hash'] == $pass) {
        $_SESSION['username'] = $_POST['email'];
        $_SESSION['id'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        //This is to stop redirect for debug use.
        //echo 'Login success';
        //print_r($_SESSION);
        //Note header == redirect for php. No idea why. Is what it is.
        header("Location: display_list.php");
    } else {
        $errMsg = 'Login failure: wrong username or password';
    }
}
if (isset($_POST['newUser'])) {
    header("Location: new_user.php");
}

if (isset($_POST['newUser'])) {
    header("Location: new_user.php");
}
//else just siplay the input form.
//IE redisplay the html below.

?>

<!DOCTYPE html>
<html lang="en-US">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <head>
        <title>Crud Applet with Login</title>
        <meta charset="utf-8"/>
    </head>
        <body>
            <h1>Curd applet with Login</h1>
            <h2>Login</h2>
            <form action="" method="post">
 
                <input type="text" class="form-control"
                name="email" placeholder="admin@admin.com"
               autofocus /> <br />
                
                <input type="password" class="form-control"
                name="password" /> <br />
                
                <button class="btn btn-lg btn-primary btn-block"
                type="submit" name="login">Login</button>
                
                <button class="btn btn-lg btn-primary btn-block"
                type="submit" name="newUser">New User</button>
                
                <button class="btn btn-lg btn-primary btn-block"
                type="submit" name="gitHub">Git Hub</button>
                
                <p style="color: red;"><?php echo $errMsg; ?></p>
            </form>
        </body>
    
</html>