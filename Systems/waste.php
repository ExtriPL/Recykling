<?php
class Waste
{
    //Nazwa pliku, w którym przechowywane są pola powieszchni poszczególnych odpadków
    public static string $wastesFile = "types.txt";

    //Zwraca listę wszystkich istniejących odpoadków, które są zmapowane na ich pole powieszchni
    public static function loadWastes() : array
    {
        $content = file_get_contents(Waste::$wastesFile);
        return json_decode($content, true);
    }
}
?>