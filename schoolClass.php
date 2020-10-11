<?php
include("user.php");

class SchoolClass
{
    public static string $classesdDir = "Classes";

    private string $classCode;
    private string $name;
    private string $location;
    private string $teacher;

    private array $students;

    public function __construct($classCode, $name, $location)
    {
        $this->classCode = $classCode;
        $this->name = $name;
        $this->location = $location;
    }

    public function setTeacher($teacherName) : void
    {
        $this->teacher = $teacherName;
    }

    public function saveClass() : void
    {
        if(!file_exists(SchoolClass::$classesdDir))
            mkdir(SchoolClass::$classesdDir);

        $classContent = serialize($this);

        file_put_contents(SchoolClass::$classesdDir."/".$this->classCode.".schclass", $classContent);
    }

    public function addStudent(string $studentName) : void
    {
        $this->students[] = $studentName;
    }

    public function addStudentAndSave(string $studentName) : void
    {
        $this->addStudent($studentName);
        $this->saveClass();
    }

    public function removeStudent(string $studentName) : void
    {
        $index = array_search($studentName, $this->students);

        if($index !== false)
            array_splice($this->students, $index, 1);
    }

    public function removeStudentAndSave(string $studentName) : void
    {
        $this->removeStudent($studentName);
        $this->saveClass();
    }

    public function isOwner(string $userName) : bool
    {
        return $this->teacher == $userName;
    }

    public function getStudents() : array
    {
        $students = array();

        foreach($this->students as $student)
            $students[] = User::loadUser($student);

        return $students;
    }

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
}
?>