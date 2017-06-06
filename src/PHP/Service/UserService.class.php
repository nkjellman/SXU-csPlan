<?php
require_once 'IUserService.interface.php';
require_once PROJECT_ROOT.'PHP/DAO/AccountDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/StudentDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/AdvisingDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/StudentsPendingApprovalQuery.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/GetAdvisorNamesQuery.class.php';
class UserService
{
    public function __construct()
    {
    }
    public function AddStudentRecord($netId, $obj, &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $success = true;
        $studentDAO = new StudentDAO($pdo);
        $advisingDAO = new AdvisingDAO($pdo);
        $student = new Student();
        $advisor = new Advisor();
        $success &= $studentDAO->Create($student->setNetId($netId)->setMajor($obj['Major'])->setTransfer($obj['Transfer'])->setYear($obj['Year']));
        $success &= $advisingDAO->Create($advisor->setNetId($obj['Adviser'])->setStudents(array($netId)));
        return  $success;
    }
    public function GetAdvisorNames($netId, &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $accountDAO = new AccountDAO($pdo);
        return $accountDAO->Find(new GetAdvisorNamesQuery());
    }
    public function HasRecord($netId, &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $accountDAO = new AccountDAO($pdo);
        $acc= new Student();
        return !is_null($accountDAO->Read($acc->setNetId($netId), BaseDAO::Single));
    }
    public function GetAllUsers($netId, &$pdo)
    {
        $accountDAO = new AccountDAO($pdo);
        if (!$this->checkPermissions($netId, $pdo, AccountType::Admin)) {
            throw new Exception("Invalid permissions");
        }
        return $accountDAO->Read(new Account(), BaseDAO::All);
    }
    public function GetStudentsForAdvisor($netId, $type, &$pdo)
    {
        $account = new Advisor();
        $studentArray = array();
        
        $studentDAO = new StudentDAO($pdo);
        $accountDAO = new AccountDAO($pdo);
        $advisingDAO = new AdvisingDAO($pdo);
        switch ($type) {
            case 'All':
                $account = $advisingDAO->Read($account->setNetId($netId), BaseDAO::All)[0];
                break;
            case 'Pending':
                $account = $advisingDAO->Find(new StudentsPendingApprovalQuery($netId))[0];
                break;
        }
        
        if (is_null($account)) {
            return array();
        }
        if ($account->getType() !== AccountType::Advisor) {
            throw new Exception("Invalid permissions");
        }
        
        foreach ($account->getStudents() as $student) {
            $accountDAO->Read($student, BaseDAO::Single);
            $studentDAO->Read($student, BaseDAO::Single);
            array_push($studentArray, $student);
        }
        return $studentArray;
    }
    public function GetStudent($netId, &$pdo)
    {
        $account = new Student();
        $advisor = new Advisor();

        $studentDAO = new StudentDAO($pdo);
        $accountDAO = new AccountDAO($pdo);
        $advisingDAO = new AdvisingDAO($pdo);
        
        $studentDAO->Read($account->setNetId($netId), BaseDAO::Single);
        $accountDAO->Read($account->setNetId($netId), BaseDAO::Single);
        $value = $accountDAO->Read($account, BaseDAO::Single);
        
        if (is_null($account)) {
            throw new Exception("No results found");
        }
        if ($account->getType() !== AccountType::Advisor) {
            throw new Exception("Invalid permissions");
        }
        
        foreach ($advisingDAO->Read($advisor->setStudents(array($netid)), BaseDAO::All) as $student) {
            $accountDAO->Read($student, BaseDAO::Single);
            $studentDAO->Read($student, BaseDAO::Single);
            array_push($studentArray, $student);
        }
        return $studentArray;
    }
    public function GetUser($netId, &$pdo)
    {
        $accountDAO = new AccountDAO($pdo);
        $account = new Account();
        $accountDAO->Read($account->setNetId($netId), BaseDAO::Single);
        return $account;
    }
    public function UpdateImage($netId, $image, &$pdo)
    {
        $accountDAO = new AccountDAO($pdo);
        $account = new Account();
        $accountDAO->Read($account->setNetId($netId), BaseDAO::Single);
        return $accountDAO->Update($account->setImage($image));
    }

    /**
     *
     * @param string $netid
     * @param PDO $pdo
     * @param string $idChange this is the id the admin will change the role for
     * @param int $role this is the new type for the id
     * @return bool
     * @throws Exception
     */
    public function ChangeRole($netid, $idChange, $role, PDO &$pdo)
    {
        if (!$this->checkPermissions($netid, $pdo, AccountType::Admin)) {
            throw new Exception("Invalid permissions");
        }
        $acc = new Account();
        $accDAO = new AccountDAO($pdo);
        $accDAO->Read($acc->setNetId($idChange), BaseDAO::Single);
        return $accDAO->Update($acc->setType($role));
    }

    /**
     * @param string $netid
     * @param string $deleteID
     * @param PDO $pdo
     * @return bool
     * @throws Exception
     */
    public function DeleteAccount($netid, $deleteID, PDO &$pdo)
    {
        if (!$this->checkPermissions($netid, $pdo, AccountType::Admin)) {
            throw new Exception("Invalid permissions");
        }
        $acc = new Account();
        $acc->setNetId($deleteID);
        $accDao = new AccountDAO($pdo);
        return $accDao->Delete($acc);
    }
    
    private function checkPermissions($netId, $pdo, $type)
    {
        if (!is_int($type)) {
            throw new InvalidArgumentException("Invalid type");
        }
        $accountDAO = new AccountDAO($pdo);
        $account = new Account();
        $accountDAO->Read($account->setNetId($netId), BaseDAO::Single);
        return $account->getType() === $type;
    }
}
