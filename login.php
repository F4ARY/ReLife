<?php

include_once("utility/db_connect.php");
session_start();

if(isset($_SESSION['id'])){
   header("location: index.php");
   exit();
}

if(isset($_GET['errore'])){
    switch ($_GET['errore']){
        case '0':
            $messaggio = "Email o Password errati";
            break;
        case '1':
            $messaggio = "Account non verificato";
            break;
        default:
            $messaggio = "Errore nel login";
            break;
    }
}

if(isset($_POST['login'])){
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $ris = $conn->query("SELECT * FROM re_utenti WHERE email = '$email' AND password_hash = SHA1(CONCAT(SHA1('$pass'), salt))");

    $riga = $ris->fetch_assoc();

    if(!isset($riga)) header("location: login.php?errore=0");
    else if($riga['confermato'] == 0) header("location: login.php?errore=1");
    else{
        $_SESSION['id'] = $riga['id_utente'];
        header("location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');

        body {
            background-color: #e9e9e9;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            line-height: 1.25;
            letter-spacing: 1px;
        }

        * {
            box-sizing: border-box;
            transition: .25s all ease;
        }

        .login-container {
            display: block;
            position: relative;
            z-index: 0;
            margin: 4rem auto 0;
            padding: 5rem 4rem 0 4rem;
            width: 100%;
            max-width: 525px;
            min-height: 680px;
            background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/283591/login-background.jpg);
            background: no-repeat;
            box-shadow: 0 50px 70px -20px rgba(0, 0, 0, 0.85);
        }

        .login-container:after {
            content: '';
            display: inline-block;
            position: absolute;
            z-index: 0;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: radial-gradient(ellipse at left bottom, rgba(22, 24, 47, 1) 0%, rgba(38, 20, 72, .9) 59%, rgba(17, 27, 75, .9) 100%);
            box-shadow: 0 -20px 150px -20px rgba(0, 0, 0, 0.5);
        }

        .form-login {
            position: relative;
            z-index: 1;
            padding-bottom: 4.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
        }

        .login-nav {
            position: relative;
            padding: 0;
            margin: 0 0 6em 1rem;
        }

        .login-nav__item {
            list-style: none;
            display: inline-block;
        }

        .login-nav__item+.login-nav__item {
            margin-left: 2.25rem;
        }

        .login-nav__item a {
            position: relative;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 1.25rem;
            padding-bottom: .5rem;
            transition: .20s all ease;
        }

        .login-nav__item.active a,
        .login-nav__item a:hover {
            color: #ffffff;
            transition: .15s all ease;
        }

        .login-nav__item a:after {
            content: '';
            display: inline-block;
            height: 10px;
            background-color: rgb(255, 255, 255);
            position: absolute;
            right: 100%;
            bottom: -1px;
            left: 0;
            border-radius: 50%;
            transition: .15s all ease;
        }

        .login-nav__item a:hover:after,
        .login-nav__item.active a:after {
            background-color: rgb(17, 97, 237);
            height: 2px;
            right: 0;
            bottom: 2px;
            border-radius: 0;
            transition: .20s all ease;
        }

        .login__label {
            display: block;
            padding-left: 1rem;
        }

        .login__label,
        .login__label--checkbox {
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            font-size: .75rem;
            margin-bottom: 1rem;
        }

        .login__label--checkbox {
            display: inline-block;
            position: relative;
            padding-left: 1.5rem;
            margin-top: 2rem;
            margin-left: 1rem;
            color: #ffffff;
            font-size: .75rem;
            text-transform: inherit;
        }

        .login__input {
            color: white;
            text-align: center;
            font-size: 1.15rem;
            width: 100%;
            padding: .5rem 1rem;
            border: 2px solid transparent;
            outline: none;
            border-radius: 1.5rem;
            background-color: rgba(255, 255, 255, 0.25);
            letter-spacing: 1px;
        }

        .login__input:hover,
        .login__input:focus {
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            background-color: transparent;
        }

        .login__input+.login__label {
            margin-top: 1.5rem;
        }

        .login__input--checkbox {
            position: absolute;
            top: .1rem;
            left: 0;
            margin: 0;
        }

        .login__submit {
            color: #ffffff;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
            padding: .75rem;
            border-radius: 2rem;
            display: block;
            width: 100%;
            background-color: rgba(17, 97, 237, .75);
            border: none;
            cursor: pointer;
        }

        .login__submit:hover {
            background-color: rgba(17, 97, 237, 1);
        }

        .login__forgot {
            display: block;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.75);
            font-size: .75rem;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .login__forgot:hover {
            color: rgb(17, 97, 237);
        }

        .errore {
            text-align: center;
            padding: 20px 0 20px 0;
            margin: 40px;
            background: rgba(255, 0, 0, .3);
            border: 1px red solid;
            border-radius: 40px;
        }

        .errore span {
            color: white;
        }
    </style>
</head>

<body>
<div class="login-container">
    <form action="login.php" class="form-login" id="formlogin" method="post">
        <ul class="login-nav">
            <li class="login-nav__item active">
                <a href="login.php">Login</a>
            </li>
            <li class="login-nav__item">
                <a href="registrazione.php">Registrati</a>
            </li>
        </ul>
        <label for="login-input-user" class="login__label">Email</label>
        <input id="login-input-user" class="login__input" type="email" name="email"/>
        <label for="login-input-password" class="login__label">Password</label>
        <input id="login-input-password" class="login__input" type="password" name="password"/>

        <input type="hidden" name="login" value="1">

        <button class="login__submit" type="submit" style="margin-top: 50px">Accedi</button>
        <?php
        if (isset($messaggio)) {
            echo '<div class="errore">
                    <span>' . $messaggio . '</span>
                  </div>';
        }
        ?>
        <br><br>
        <span style="margin-left: 10%; color: #c2c2c2">Sei un dipendente? Fai l'accesso <a style="color: rgb(17, 97, 237); text-decoration: none; font-weight: 900" href="admin.php">qui</a></span>
    </form>
    <a class="login__forgot">&copy; George Patrut, 2021 </a>
</div>

</body>

</html>
