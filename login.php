<?php

include('./database.php');

session_start();

$message = "";

if (isset($_SESSION['username'])) {
    header('Location: panel.php');
}


if (isset($_POST['username'])) {
    $form_username = $_POST['username'];
    $form_password = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select * from users where username='" . mysqli_real_escape_string($conn, $form_username) . "'limit 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($form_password, $row['pass'])) {
                $_SESSION['username'] = $form_username;
                header('Location:panel.php');
            } else {
                $message = "Wrong Password";
            }
        }
    } else {
        $message = "No User Account";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');


        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        .main {
            margin: auto;
            margin-top: 50px;
            width: 50%;
            border-radius: 10px;
            padding: 20px 50px;
        }

        .form_div {
            margin-top: 30px;
        }

        .form_input {
            margin-bottom: 20px;
            padding: 10px;
            width: 200px;
            border: 1px solid #ddd;
            box-shadow: none;
            outline: none;
            border-radius: 5px;
        }

        .login_btn{
            padding: 5px 10px;
            background: #eee;
            border: 1px solid #333;
            border-radius: 5px;
            cursor: pointer;
        }

        .message{
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="main">
        <h1>Control Panel</h1>
        <p class="message">
            <?php echo $message;?>
        </p>
        <form action="#" class="form_div" method="post">
           <div>
                <input type="text" class="form_input" name="username" placeholder="Username">
            <input type="password" class="form_input" name="password" placeholder="Password">
           </div>
            <button type="submit" class="login_btn">Login</button>
        </form>
    </div>
</body>

</html>