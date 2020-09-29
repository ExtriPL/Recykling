<?php
    session_start();
?>

<html lang='pl'>
    <head>
        <meta charset = 'utf-8'>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form action="login.php" method = "post">
            <label for="nickname">Login</label><input type="text" name="nickname"><br>
            <label for="password">Hasło<input type="password" name="password"><br>
            <button action = "submit">ZALOGUJ</button>
        </form>

        <?php
            if(isset($_SESSION["back-message"]))
            {
                echo "<p style='color:red;'>".$_SESSION["back-message"]."</p>";
                unset($_SESSION["back-message"]);
            }
        ?>
    </body>
</html>