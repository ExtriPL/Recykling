<?php
    session_start();

    include("Systems/user.php");

    $nick = strtolower(htmlspecialchars($_POST['nazwa1']));
    $password = htmlspecialchars($_POST['nazwa2']);

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

    if(User::loginMasterUser($nick, $password))
    {
        $_SESSION["isMaster"] = true;

        header("Location: adminPanel.php");
        exit();
    }
    else if(User::exists($nick))
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