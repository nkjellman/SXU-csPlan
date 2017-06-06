<?php
require_once 'IAuthenticationService.interface.php';
require_once PROJECT_ROOT .'PHP/Models/Account.class.php';
require_once PROJECT_ROOT .'PHP/Models/Name.class.php';
require_once PROJECT_ROOT .'PHP/Models/Enums/AccountType.Enum.php';

/*
    Provides simple authentication that accepts three users -> student, advisor, and admin with the passwords being the username. Stores true or false if logged in as well as username for authroization purposes.
*/

class MockAuthenticationService implements IAuthenticationService {
    private $list;

    /**
     *  Give this an assoc array list of students, or just use the DI Container
     * @param array $u
     */
    
    public function __construct() {
        $this->list = array("sg70203:pass" => Account::CreateAccount("sg70203",new Name("Santos", "Gibson"),AccountType::Student, "SGibson@mymail.sxu.edu",null),
                            "dh6:pass" => Account::CreateAccount("dh6",new Name("Denise", "Henry"),AccountType::Advisor, "advisor@sample.com",null),
                            "ef7:pass" => Account::CreateAccount("ef7",new Name("Emily", "Frazier"),AccountType::Admin, "admin@sample.com",null));
    }

    /**
     * Authenticates a user by username and password, then returns a new Object as a result if it exists in the list
     * @param String $user
     * @param String $pass
     * @return \User
     * @throws Exception
     */

    public function Authenticate($user, $pass) {
        $auth = $user.':'.$pass;
        return array_key_exists($auth, $this->list) ? $this->list[$auth] : null;
    }
}