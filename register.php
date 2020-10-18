<?php
    session_start();

    include("schoolClass.php");

    $userName;
    if(isset($_POST["nickname"]))
       $userName = strtolower(htmlspecialchars($_POST["nickname"]));
    else
    {
        $_SESSION["back-message"] = "Nie podano nazwy użytkownika";
        header("Location: registerUser.php");
        exit();
    }

    $password;
    if(isset($_POST["password"]) && strlen($_POST["password"]) > 5)
        $password = htmlspecialchars($_POST["password"]);
    else
    {
        $_SESSION["back-message"] = "Podane hasło jest zbyt krótkie";
        header("Location: registerUser.php");
        exit();
    }
    $role = htmlspecialchars($_POST["role"]);

    $classCode;
    if(isset($_POST["classCode"]))
    {
        $classCode = htmlspecialchars($_POST["classCode"]);
    }
    else
    {
        $_SESSION["back-message"] = "Nie podano kodu klasy";
        header("Location: registerUser.php");
        exit();
    }

    if(!User::exists($userName))
    {
        if($role == "teacher")
        {
            //Tworzenie klasy
            $schoolName = htmlspecialchars($_POST["schoolName"]);
            $schoolLocation = htmlspecialchars($_POST["schoolLocation"]);

            $class = new SchoolClass($classCode, $schoolName, $schoolLocation);
            $class->setTeacher($userName);
            $class->saveClass();
        }
        else if(SchoolClass::exists($classCode))
        {
            $class = SchoolClass::loadClass($classCode);
            $class->addStudent($userName);
            $class->saveClass();
        }
        else
        {
            $_SESSION["back-message"] = "Klasa o podanym kodzie nie istnieje";
            header("Location: registerUser.php");
            exit();
        }

        $user = new User($userName, password_hash($password, PASSWORD_DEFAULT), $role, $classCode);
        $user->saveUser();

        $_SESSION["back-message"] = "Pomyślnie zarejestrowano konto";
        header("Location: index.php");
        exit();
    }
    else
    {
        $_SESSION["back-message"] = "Podana nazwa użytkownika jest zajęta";
        //Odsyłanie do strony z informacją, że taki użytkownik istnieje
        header("Location: registerUser.php");
        exit();
    }
?>