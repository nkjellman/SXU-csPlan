<?php
require_once "IAuthorizationService.interface.php";
require_once "IAuthenticationService.interface.php";
require_once "ISessionStore.interface.php";
require_once PROJECT_ROOT . 'PHP/DAO/AccountDAO.class.php';
require_once PROJECT_ROOT . 'PHP/DAO/BaseDAO.class.php';

class AuthorizationService implements IAuthorizationService
{
    /**
    * Authentication Service
    * @var AuthenticationService
    */
    private $_AuthenticationService;
    /**
    * Session Store
    * @var SessionStore
    */
    private $_SessionStore;
    /**
    * Class constructor
    * @param IAuthenticationService AuthenticationService
    * @param ISessionStore SessionStore
    */
    public function __construct(IAuthenticationService $authService, ISessionStore $sessionStore)
    {
        if (is_null($authService)) {
            throw new Exception("Invalid input authService");
        }
        if (is_null($sessionStore)) {
            throw new Exception("Invalid input sessionStore");
        }
        $this->_AuthenticationService = $authService;
        $this->_SessionStore = $sessionStore;
    }

    /**
    * Request a login from the LDAP server
    * @param String $user The Username
    * @param String $pass The Password
    * @return String
    */
    public function Login($user, $pass, PDO &$pdo)
    {
        if (!is_string($user)) {
            throw new InvalidArgumentException("Invalid username input");
        }
        if (!is_string($pass)) {
            throw new InvalidArgumentException("Invalid password input");
        }
        $accountDAO = new AccountDAO($pdo);
        $user = $this->_AuthenticationService->Authenticate($user, $pass);
        if (!is_null($user)) {
            $userInfo = array("Time" => time());
            //if not in db, push them.
            $search = new Account();
            if (is_null($accountDAO->Read($search->setNetId($user->getNetId()), BaseDAO::Single))) {
                $accountDAO->Create($user);
            }
            $this->_SessionStore->Add("net_id", $user->getNetId());
            $this->_SessionStore->Add("id", session_id());
            $this->_SessionStore->Add("Time", time());
            return true;
        }
        return false;
    }
    /**
    * Checks if token is still valid from session store
    * @param String $token The Token
    * @return Boolean
    */
    public function IsValidSession()
    {
            $this->_SessionStore->IsAuthenticated();
    }
    /**
    * Remove token from session store
    * @param String $token The Token
    * @param String $pass The Password2
    */
    public function Logout()
    {
        session_destroy();
    }
}
