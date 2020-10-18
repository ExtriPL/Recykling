<?php
    session_start();

    include("user.php");

    $nick = strtolower(htmlspecialchars($_POST['nickname']));
    $password = htmlspecialchars($_POST['password']);

    function discardLogin() : void
    {
        $_SESSION["back-message"] = "Nazwa użytkownika lub hasło są nieprawidłowe";
        header("Location: index.php");
        exit();
    }

    function acceptLogin() : void
    {
        global $nick;

        $_SESSION["loggedIn"] = true;
        $_SESSION["userName"] = $nick;
        
        header("Location: userPage.php");
        exit();
    }

    if(User::exists($nick))
    {
        $user = User::loadUser($nick);
        $isValid = $user->verifyPassword($password);

        if($isValid)
            acceptLogin();
        else
            discardLogin();
    }
    else
        discardLogin();
?>