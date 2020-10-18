<!doctype html>
<html lang="pl">
    <head>
        <meta charset="utf-8">

        <script src="script.js"></script>
    </head>
    <body>
        <form action="register.php" method="post">
            <label for="nickname">Nazwa użytkownika: </label><input type="text" id="nickname" name="nickname"><br>
            <label for="password">Hasło: </label><input type="password" id="password" name="password"><br>
           
            Rola:<br>
            <input type="radio" id="role1" name="role" value="teacher" onclick="chanceVisible(false);"><label for="role1">Nauczyciel</label>
            <input type="radio" id="role2" name="role" value="student" onclick="chanceVisible(true);" checked><label for="role2">Uczeń</label>
            <br><br>
            
            <div id="studentSelected">
                <label for="classCode">Kod klasy: </label><input type="text" id="classCode" name="classCode"><br>
            </div>
            <div id="teacherSelected" style="display:none">
                <label for="schoolName">Nazwa szkoły: </label><input type="text" id="schoolName" name="schoolName"><br>
                <label for="schoolLocation">Adres szkoły: </label><input type="text" id="schoolLocation" name="schoolLocation"><br>
                <label for="classCode">Kod klasy: </label><input type="text" id="classCode" name="classCode"><br>
            </div>

            <input type="submit" value="Zarejestruj się">
        </form>
    </body>
</html>