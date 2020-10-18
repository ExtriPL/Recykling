<?php
class User
{
    //Folder, w którym przechowywani są użytkownicy
    public static string $accountsDir = "Users";

    public string $userName;
    //Hasło w postaci hasha
    private string $passKey;
    //Rola użytkownika w klasie ("student" - uczeń, "teacher" - nauczyciel)
    private string $role;
    //Kod klasy, do której przypisany jest użytkownik
    private string $classCode;
    //Lista odpadków, które zebrał użytkownik
    private array $wastes;

    public function __construct(string $userName, string $passKey, string $role, string $classCode)
    {
        $this->userName = $userName;
        $this->passKey = $passKey;
        $this->role = $role;
        $this->classCode = $classCode;
        $this->wastes = array();
    }

    //Funkcja służąca do sprawdzenia zgodności wpisanego hasła z jego hashem
    public function verifyPassword(string $password) : bool
    {
        return password_verify($password, $this->passKey);
    }

    //Funkcja zapisuje instancje użytkownika do pliku
    public function saveUser() : void
    {
        $userString = serialize($this);

        if(!file_exists(User::$accountsDir))
            mkdir(User::$accountsDir);

        if(!file_exists(User::$accountsDir."/".$this->classCode))
            mkdir(User::$accountsDir."/".$this->classCode);

        file_put_contents(User::$accountsDir."/".$this->classCode."/".$this->userName.".user", $userString);
    }

    //Dodaje odpadek o podanej nazwie do listy odpadków
    public function addWaste(string $name, int $amount) : void
    {
        $currentAmount = 0;
        if(array_key_exists($name, $this->wastes))
            $currentAmount = $this->wastes[$name];

        $this->wastes[$name] = $currentAmount + $amount;
    }

    //Dodaje podaną listę odpadków do listy użytkownika
    public function addWastes(array $wastes) : void
    {
        foreach($wastes as $name => $amount)
            $this->addWaste($name, $amount);
    }

    //Dodaje odpadek do listy użytkownika i zapisuje zmiany w pliku
    public function addWasteAndSave(string $name, int $amount) : void
    {
        $this->addWaste($name, $amount);
        $this->saveUser();
    }

    //Dodaje liste odpadków do listy użytkownika i zapisuje zmiany w pliku
    public function addWastesAndSave(array $wastes) : void
    {
        $this->addWastes($wastes);
        $this->saveUser();
    }

    //Zwraca wszystkie nazwy odpadków, jakie posiada użytkownik
    public function getWasteNames() : array
    {
        return array_keys($this->wastes);
    }

    //Zwraca ilość odpadków o podanej nazwie, które są w posiadaniu użytkownika
    public function getWasteAmount(string $name) : int
    {
        if(array_key_exists($name, $this->wastes))
            return $this->wastes[$name];
        else
            return 0;
    }

    //Zwraca informację, czy użytkownik jest uczniem. Jeżeli false oznacza, że użytkownik jest nauczycielem
    public function isStudent() : bool
    {
        return $this->role == "student";
    }

    //Ustawia kod klasy użytkownika
    public function setClassCode(string $classCode) : void
    {
        $this->classCode = $classCode;
    }

    //Sprawdza, czy użytkownik należy do klasy o podanym kodzie
    public function inClass(string $classCode) : bool
    {
        return $this->classCode == $classCode;
    }

    //Sprawdza, czy użytkownik o podanej nazwie istnieje
    public static function exists(string $userName) : bool
    {
        if(!file_exists(User::$accountsDir))
            mkdir(User::$accountsDir);

        if(User::getUserClassCode($userName) !== false)
            return true;
        else
            return false;
    }

    public static function getUserClassCode($userName)
    {
        if(!file_exists(User::$accountsDir))
            mkdir(User::$accountsDir);

        $userFolders = scandir(User::$accountsDir);

        foreach($userFolders as $folder)
        {
            if($folder != "." && $folder != ".." && is_dir(User::$accountsDir."/".$folder))
            {
                $users = scandir(User::$accountsDir."/".$folder);
                foreach($users as $user)
                {
                    if($user == $userName.".user")
                        return $folder;
                }
            }
        }

        return false;
    }

    //Zwraca instancje użytkownika wczytaną z pliku
    public static function loadUser(string $userName) : User
    {
        $userClass = User::getUserClassCode($userName);
        if($userClass !== false)
        {
            $userContent = file_get_contents(User::$accountsDir."/".$userClass."/".$userName.".user", true);

            return unserialize($userContent);
        }
        else
            return new User("", "", "student", "");
    }
}
?>