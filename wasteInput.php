<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
</head>
<body>
<?php   
$fileWithTypesName = "types.txt";
$wasteTypeArray = [];

function openFile($fileName,$arrayName)
{
if(file_exists($fileName))
{
    $fileOptions = fopen($fileName,"r");
    while(!feof($fileOptions))
    {   
        $line = fgets($fileOptions);
        array_push($arrayName,$line);
    }
    fclose($fileOptions);
    echo "<label for='typeofWaste'>Wybierz typ odpadku: </label>
    <select name='typeOfWaste' id='typeofWaste'>";
    foreach($arrayName as $item)
    {
        echo "<option value=".$item.">".$item."</option>";
    }
    echo "</select>";
}
else
{
    echo "Plik nie istnieje lub jest niepoprawny";
}
}

openFile($fileWithTypesName,$wasteTypeArray);

echo "&nbsp
<label for='amountOfWaste'>Ilość odpadku: </label>
<input type='number' id='amountOfWaste' name='amountOfWaste' min='1'>";

?>
</body>
</html>