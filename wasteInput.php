<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
</head>
<body>

<label for="typeofWaste">Wybierz typ odpaku: </label>

<select name="typeOfWaste" id="typeofWaste">
<option value="butelka">Butelka</option>
<option value="puszka">Puszka</option>
</select>
&nbsps
<label for="amountOfWaste">Ilość odpadku: </label>

<input type="number" id="amountOfWaste" name="amountOfWaste" min="1">

<?php   
$fileOptions;
function openFile($fileName)
{
if(file_exists($fileName))
{
    $fileOptions = fopen($fileName,"r");
    while(!feof($fileOptions))
    {
        fgets($fileOptions);
    }
    fclose($fileOptions);
}
else
{
    echo "Plik nie istnieje lub jest niepoprawny";
}
}

?>
</body>
</html>