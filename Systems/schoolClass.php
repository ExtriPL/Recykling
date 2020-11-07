<?php
include("user.php");
class SchoolClass
{
    //Folder, w którym przechowywane są pliki klas
    public static string $classesdDir = "Classes";

    //Kod klasy
    private string $classCode;
    //Pełna nazwa szkoły
    private string $name;
    //Adres szkoły
    private string $location;
    //Nazwa użytkownika, który jest nauczycielem tej klasy
    private string $teacher;

    private array $students;

    public function __construct(string $classCode, string $name, string $location)
    {
        $this->classCode = $classCode;
        $this->name = $name;
        $this->location = $location;
        $this->students = array();
    }

    public function setTeacher($teacherName) : void
    {
        $this->teacher = $teacherName;
    }

    //Zapisuje plik klasy do pliku
    public function saveClass() : void
    {
        if(!file_exists(SchoolClass::$classesdDir))
            mkdir(SchoolClass::$classesdDir);

        $classContent = serialize($this);

        file_put_contents(SchoolClass::$classesdDir."/".$this->classCode.".schclass", $classContent);
    }

    //Dodaje ucznia o podanej nazwie do danej klasy
    public function addStudent(string $studentName) : void
    {
        $this->students[] = $studentName;
    }

    //Dodaje ucznia o podanej nazwie do danej klasy i zapisuje zmiany do pliku
    public function addStudentAndSave(string $studentName) : void
    {
        $this->addStudent($studentName);
        $this->saveClass();
    }

    //Usuwa ucznia z danej klasy
    public function removeStudent(string $studentName) : void
    {
        $index = array_search($studentName, $this->students);

        if($index !== false)
            array_splice($this->students, $index, 1);
    }

    //Usuwa ucznia z danej klasy i zapisuje zmiany do pliku
    public function removeStudentAndSave(string $studentName) : void
    {
        $this->removeStudent($studentName);
        $this->saveClass();
    }

    //Sprawdza, czy użytkownik o podanej nazwie jest nauczycielem, który zarejestrował klasę
    public function isOwner(string $userName) : bool
    {
        return $this->teacher == $userName;
    }

    //Zwraca instancje uczniów, którzy należą do klasy
    public function getStudents() : array
    {
        $students = array();
        foreach($this->students as $student)
            $students[] = User::loadUser($student);

        return $students;
    }

    //Zwraca pole powieszchni wszystkich odpadków zebranych przez klasę
    public function getWastesArea() : float
    {
        $area = 0.0;

        foreach($this->getStudents() as $student)
            $area += $student->getWastesArea();

        return $area;
    }

    //Zwraca pole powieszchni wszystkich odpadków zebranych przez klasę do podanej daty
    public function getWastesAreaToDate(string $date) : float
    {
        $area = 0.0;

        foreach($this->getStudents() as $student)
            $area += $student->getWastesAreaToDate($date);

        return $area;
    }

    //Zwraca pole powieszchni wszystkich odpadków zebranych przez klasę w podanym dniu
    public function getWastesAreaInDate(string $date) : float
    {
        $area = 0.0;

        foreach($this->getStudents() as $student)
            $area += $student->getWastesAreaInDate($date);

        return $area;
    }

    public function getWastesAreaBetweenDates(string $first, string $second) : float
    {
        $area = 0.0;

        foreach($this->getStudents() as $student)
            $area += $student->getWastesAreaBetweenDates($first, $second);

        return $area;
    }

    public static function getWastesAreaOfAll() : float
    {
        $area = 0.0;

        foreach(SchoolClass::getAllClasses() as $class)
            $area += $class->getWastesArea();

        return $area;
    }

    public static function getWastesAreaToDateOfAll(string $date) : float
    {
        $area = 0.0;

        foreach(SchoolClass::getAllClasses() as $class)
            $area += $class->getWastesAreaToDate($date);

        return $area;
    }

    public static function getWastesAreaInDateOfAll(string $date) : float
    {
        $area = 0.0;

        foreach(SchoolClass::getAllClasses() as $class)
            $area += $class->getWastesAreaInDate($date);

        return $area;
    }
    
    public static function getWastesAreaBetweenDatesOfAll(string $first, string $second) : float
    {
        $area = 0.0;

        foreach(SchoolClass::getAllClasses() as $class)
            $area += $class->getWastesAreaBetweenDates($first, $second);

        return $area;
    }

    public static function getAllClassCodes() : array
    {
        $classCodes = [];
        $fileNames = scandir(SchoolClass::$classesdDir);

        foreach($fileNames as $fileName)
        {
            if(strpos($fileName, ".schclass") !== false)
                $classCodes[] = explode(".", $fileName)[0];
        }

        return $classCodes;
    }

    public static function getAllClasses() : array
    {
        $classCodes = SchoolClass::getAllClassCodes();
        $classes = [];

        foreach($classCodes as $classCode)
            $classes[] = SchoolClass::loadClass($classCode);

        return $classes;
    }

    //Sprawdza, czy klasa o podanym kodzie istnieje
    public static function exists(string $classCode) : bool
    {
        if(!file_exists(SchoolClass::$classesdDir))
            mkdir(SchoolClass::$classesdDir);

        $classes = scandir(SchoolClass::$classesdDir);

        foreach($classes as $class)
        {
            if($class == $classCode.".schclass")
                return true;
        }

        return false;
    }

    //Wczytuje instancje klasy o podanym kodzie z pliku
    public static function loadClass(string $classCode) : SchoolClass
    {
        if(SchoolClass::exists($classCode))
        {
            $classContent = file_get_contents(SchoolClass::$classesdDir."/".$classCode.".schclass", true);

            return unserialize($classContent);
        }
        else
            return new SchoolClass("", "", "");
    }

    //Usuwa użytkownika z bazy
    public static function removeUser($userName)
    {
        if(User::exists($userName))
        {
            $classCode = User::getUserClassCode($userName);
            unlink(User::$accountsDir."/".$classCode."/".$userName.".user");

            $class = SchoolClass::loadClass($classCode);
            $class->removeStudent($userName);
            $class->saveClass();
        }
    }
}
?>