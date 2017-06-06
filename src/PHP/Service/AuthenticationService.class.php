<?php
require_once "IAuthenticationService.interface.php";
require_once PROJECT_ROOT . 'PHP/Models/Account.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Name.class.php';
require_once PROJECT_ROOT . 'PHP/Models/Enums/AccountType.enum.php';
class AuthenticationService implements IAuthenticationService
{
    private $LDAPConn;
    private $Domain;
    /**
    * AuthenticationService Constructor
    * @param String $host The AD host
    * @param String $domain The domain
    */
    public function __construct($host, $domain)
    {
        if (!is_string($host)) {
            throw new Exception("Invalid string input");
        }
        if (!is_string($domain)) {
            throw new Exception("Invalid string input");
        }
        $this->LDAPConn = ldap_connect($host) or die("Failed Connecttion");
        $this->Domain = $domain;
    }

    /**
    * Checks if login attempt is valid
    * @param String $user The username
    * @param String $pass The password
    * @return Account - parsed from valid AD / else null.
    */
    public function Authenticate($user, $pass)
    {
        // null checks
        if (!is_string($user)) {
            throw new InvalidArgumentException("Invalid username input");
        }
        if (!is_string($pass)) {
            throw new InvalidArgumentException("Invalid password input");
        }
        // set LDAP options
        ldap_set_option($this->LDAPConn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->LDAPConn, LDAP_OPT_REFERRALS, 0);

        $userInfo = null;

        // if successful bind, let's work some magic and parse that data
        if (ldap_bind($this->LDAPConn, $user . '@' . $this->Domain, $pass)) {
            // search, sort, then get entries into info
            $result = ldap_search($this->LDAPConn, "dc=cs,dc=local", "(sAMAccountName=$user)");
            ldap_sort($this->LDAPConn, $result, "sn");
            $info = ldap_get_entries($this->LDAPConn, $result);
            // double check we're doing okay in our endeavour of reading from AD
            if (array_key_exists("count", $info) && $info["count"] === 1) {
                // parse the data into an account.
                // CN, OU, DC,DC
                $userInfo = new Account();
                $DN = explode(',', $info[0]["dn"]);
                $name = explode(' ', substr($DN[0], 3));
                $userInfo->setEmail($info[0]["mail"][0])->setName(new Name($name[1],$name[0]))->setNetId($user);
                switch (substr($DN[1], 3)) {
                    case "Students":
                        $userInfo->setType(AccountType::Student);
                        break;
                }
            }
        }
        return $userInfo;
    }
}
