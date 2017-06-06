<?php
require_once('ISessionStore.interface.php');

class SessionStore implements ISessionStore
{
    /**
    * Expiration interval
    * @var Int
    */
    private $Interval;
     /**
     * Class constructor
     */
    public function __construct()
    {
        // set interval to two weeks
        $this->Interval = (14 * 24 * 60 * 60);
    }
    /**
    * Add element to session storage
    * @param $id String
    * @param $info Array
    */
    public function Add($key, $value)
    {
        if (!is_string($key)) {
            throw new Exception("Invalid key input");
        }
        if (is_null($value)) {
            throw new Exception("Invalid value input");
        }
            $_SESSION[$key] = $value;
    }
    /**
    * Remove element from session storage
    * @param $id String
    * @return Boolean
    */
    public function Remove($id)
    {
        if (!is_string($id)) {
            throw new Exception("Invalid token input");
        }
        if (array_key_exists($id)) {
            unset(self::$sessionStorage[$id]);
            unset($id);
            return true;
        };
         return false;
    }
    /**
    * Validates if token is still valid.
    * @param $id String
    * @return Boolean
    */
    public function IsAuthenticated()
    {
        if (!array_key_exists($id, self::$sessionStorage)) {
            return false;
        }
        return $this->IsInInterval($id);
    }
    /**
    * Validates if token is in the interval.
    * @param $id String
    * @return Boolean
    */
    private function IsInInterval()
    {
        $currentTime = time();
         $user = $_SESSION;
        if ($user->Time > ($currentTime - $this->Interval)) {
            Add('Time',$currentTime);
            return true;
        }
            session_destroy();
            return false;
    }
}
