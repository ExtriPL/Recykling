<?php
class User
{
    public static string $accountsDir = "Users";

    private string $userName;
    private string $passKey;
    private array $wastes;

    public function __construct($userName, $passKey)
    {
        $this->userName = $userName;
        $this->passKey = $passKey;
        $this->wastes = array();
    }

    public function verifyPassword($password) : bool
    {
        return password_verify($password, $this->passKey);
    }

    public function saveUser() : void
    {
        $userString = serialize($this);
        file_put_contents(User::$accountsDir."/".$this->userName.".user", $userString);
    }

    public function addWaste(string $name, int $amount) : void
    {
        $currentAmount = 0;
        if(array_key_exists($name, $this->wastes))
            $currentAmount = $this->wastes[$name];

        $this->wastes[$name] = $currentAmount + $amount;
    }

    public function addWastes(array $wastes) : void
    {
        foreach($wastes as $name => $amount)
            $this->addWaste($name, $amount);
    }

    public function addWasteAndSave(string $name, int $amount) : void
    {
        $this->addWaste($name, $amount);
        $this->saveUser();
    }

    public function addWastesAndSave(array $wastes) : void
    {
        $this->addWastes($wastes);
        $this->saveUser();
    }

    public function getWasteNames() : array
    {
        return array_keys($this->wastes);
    }

    public function getWasteAmount(string $name) : int
    {
        if(array_key_exists($name, $this->wastes))
            return $this->wastes[$name];
        else
            return 0;
    }

    public static function exists($userName) : bool
    {
        if(!file_exists(User::$accountsDir))
            mkdir(User::$accountsDir);

        $users = scandir(User::$accountsDir);

        foreach($users as $userFile)
        {
            if($userFile == $userName.".user")
                return true;
        }

        return false;
    }

    public static function loadUser($userName) : User
    {
        if(User::exists($userName))
        {
            $userContent = file_get_contents(User::$accountsDir."/".$userName.".user", true);

            return unserialize($userContent);
        }
        else
            return new User("", "");
    }
}
?>