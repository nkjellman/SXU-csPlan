<?php
require_once 'ICourseService.interface.php';
require_once PROJECT_ROOT.'PHP/DAO/CourseDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/BaseDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/CourseOfferingsDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/CourseSelectionDAO.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/SearchCoursesQuery.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/GetUnapprovedCourseSelectionsQuery.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/SearchCoursesPerPreReq.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/GetTotalCreditsQuery.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/GetStudentTotalPerCourseQuery.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/PredictCourseOccupancyQuery.class.php';
require_once PROJECT_ROOT.'PHP/DAO/Queries/DropTableExistsQuery.class.php';
require_once PROJECT_ROOT.'PHP/Models/Enums/AccountType.enum.php';
require_once PROJECT_ROOT.'PHP/Models/Course.class.php';
require_once PROJECT_ROOT.'PHP/Models/CourseOffering.class.php';
require_once PROJECT_ROOT.'PHP/Models/Department.class.php';

class CourseService implements ICourseService
{
    public function __construct()
    {
    }

    public function getCoursesForStudent($netId, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        
        $courseOfferings = new CourseOfferingsDAO($pdo);
    }

    public function SearchCourses($netId, $year, $semester, $name, $num, $dept, $all, PDO &$pdo)
    {
        $query = ($this->checkPermissions($netId, $pdo, AccountType::Student)) ?
         $all ? new SearchCoursesQuery($year, $semester) : new SearchCoursesPerPreReq($netId, $semester, $year) :
         new GetStudentTotalPerCourseQuery();
        $courseOfferings = new CourseOfferingsDAO($pdo);
        $course = new CourseDAO($pdo);
        $courseofferings = $courseOfferings->Find($query);
        $courses = $course->Find($query);
        $count = count($courseofferings);
        if ($count == count($courses)) {
            for ($i = 0; $i < $count; $i++) {
                $courseofferings[$i]->setName($courses[$i]->getName())
                                ->setNumber($courses[$i]->getNumber())
                                ->setDepartment($courses[$i]->getDepartment())
                                ->setCredits($courses[$i]->getCredits())
                                ->setDescription($courses[$i]->getDescription())
                                ->setElective($courses[$i]->isElective());
            }
        }
        return $courseofferings;
    }
    /**
    * This adds a course using the courseDAO - returns true or false on successful execution
    * @param String $netId netid to check permission for advisor status
    * @param Course $course Course Object
    * @param PDO $pdo The Connection
    * @return boolean
    */
    public function AddCourse($netId, $course, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
        $courseDAO = new CourseDAO($pdo);
        $coDAO = new CourseOfferingsDAO($pdo);
        $newCourse = new CourseOffering();
        $newCourse->setNumber((int) $course['Number'])
                                     ->setDepartment(Department::GetDepartment((int) $course['Department']))
                                     ->setName($course['Name'])
                                     ->setDescription($course['Description'])
                                     ->setCredits(0)
                                     ->setYear((int)date('Y'))
                                     ->setSemester('F');
        return $courseDAO->Create($newCourse) &  $coDAO->Create($courseDAO->Read($newCourse,BaseDAO::Single)); 
        
    }

    /**
    * This removes a course using the courseDAO - returns true or false on successful execution
    * @param String $netId netid to check permission for advisor status
    * @param Course $course Course Object
    * @param PDO $pdo The Connection
    * @return boolean
    */

    public function RemoveCourse($netId, $obj, PDO &$pdo)
    {
        $course = new Course();
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
        $courseDAO = new CourseDAO($pdo);
        return $courseDAO->Delete($course->setId($obj['Id']));
    }

    /**
    * This edits a course using the courseDAO - returns true or false on successful execution
    * @param String $netId netid to check permission for advisor status
    * @param Course $course Course Object
    * @param PDO $pdo The Connection
    * @return boolean
    */

    public function EditCourse($netId, $obj, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
         $courseDAO = new CourseDAO($pdo);
         $course = new Course();
         $courseDAO->Read($course->setId($obj['Id']), BaseDAO::Single);
         return $courseDAO->Update($course->setName($obj['Name'])->setDepartment(Department::GetDepartment($obj['Department']))->setNumber($obj['Number'])->setDescription($obj['Description'])) ?
                $course: null;
    }

    /**
    * This gets a SINGLE course using the courseDAO - returns true or false on successful execution
    * @param Course $course Course Object
    * @param PDO $pdo The Connection
    * @return Course
    */

    public function getCourse($course, PDO &$pdo)
    {
         $courseDAO = new CourseDAO($pdo);
         return $courseDAO->Read($course, $courseDAO::Single);
    }

    /**
    * This gets all courses using the courseDAO - returns arrau on successful execution
    * @param Course $course Course Object
    * @param PDO $pdo The Connection
    * @return array
    */

    public function getAllCourses($netId, PDO &$pdo)
    {
         $courseDAO = new CourseDAO($pdo);
         return $courseDAO->Read($course = new Course(), $courseDAO::All);
    }
    public function GetTotalCredits($netId, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $course = new CourseDAO($pdo);
        return (int)$course->Run(new GetTotalCreditsQuery($netId), BaseDAO::Single)['Credits'];
    }

    /**
    * This gets MULTIPLE courses using the courseDAO, not a search - strict terms - by id, same name, type, etc. - returns true or false on successful execution
    * @param Course $course Course Object
    * @param PDO $pdo The Connection
    * @return array
    */

    public function getCourses($course, PDO &$pdo)
    {
         $courseDAO = new CourseDAO($pdo);
         return $courseDAO->Read($course, $courseDAO::All);
    }

    /**
    * Checks to see if user is an advisor or not
    * @param String $netId netid to check permission for advisor status
    * @param PDO $pdo The Connection
    * @return boolean
    */

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

    /**
    * This adds a courseselection using the courseselectionDAO - returns true or false on successful execution
    * @param String $stu_id String for student netid
    * @param String $courseid Course idate
    * @param int $year Year of addCourse
    * @param char $semester - semester offered
    * @param int $perference - preference night or day
    * @param String $comment - Special comment
    * @param PDO $pdo The Connectionurses
    * @return boolean
    */

    public function AddCoursesToSelection($netId, $courses, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $selectionDAO = new CourseSelectionDAO($pdo);
        $courseSelections = array();
        foreach ($courses as &$course) {
                array_push($courseSelections, CourseSelection::CreateSelection((int) $course['Id'], (int) $course['Year'], $course['Semester'], array_key_exists('Preference', $course) ? $course['Preference'] : 0, null, false));
        }
        $student = new Student();
        return $selectionDAO->Create($student->setNetId($netId)
                                             ->setCourses($courseSelections));
    }
    public function PredictCourses($netId, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
        $query = new PredictCourseOccupancyQuery();
        $courseOfferings = new CourseOfferingsDAO($pdo);
        $course = new CourseDAO($pdo);
        $courseofferings = $courseOfferings->Find($query);
        $courseOfferings->Run(new DropTableExistsQuery(), BaseDAO::Single);
        $courses = $course->Find($query);
        $course->Run(new DropTableExistsQuery(), BaseDAO::Single);
        $count = count($courseofferings);
        if ($count == count($courses)) {
            for ($i = 0; $i < $count; $i++) {
                $courseofferings[$i]->setName($courses[$i]->getName())
                                    ->setNumber($courses[$i]->getNumber())
                                    ->setDepartment($courses[$i]->getDepartment());
            }
        }
        return $courseofferings;
    }
    public function ApproveCourses($netId, $obj, &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
        $courseSelectionDAO = new CourseSelectionDAO($pdo);
        $courses = array();
        $student = new Student();
        $courses = array();
        foreach ($obj['Courses'] as $course) {
            array_push($courses, CourseSelection::CreateSelection($course['Id'], $course['Year'], $course['Semester']));
        }
        $student = current($courseSelectionDAO->Read($student->setNetId($obj['Student'])->setCourses($courses), BaseDAO::All));
        if ($obj['Approve']) {
            foreach ($student->getCourses() as $course) {
                $temp = new Student();
                $courseSelectionDAO->Update($temp->setNetId($obj['Student'])->setCourses(array($course->setApproved(true))));
            }
            return true;
        } else {
            $courseSelectionDAO->Delete($student);
            return true;
        }
    }
    public function GetCoursesFromSelection($netId, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $selectionDAO = new CourseSelectionDAO($pdo);
        $courseDAO = new CourseDAO($pdo);
        $student = new Student();
        $student = $selectionDAO->Read($student->setNetId($netId), BaseDAO::All);
        if (count($student) < 1) {
            return null;
        }
        $courses = array();
        foreach (current($student)->getCourses() as $course) {
            array_push($courses, $courseDAO->Read($course, BaseDAO::Single));
        }
        return current($student)->setCourses($courses)->getCourses();
    }

    /**
    * This removes a courseselection using the courseselectionDAO - returns true or false on successful execution
    * @param String $stu_id String for student netid
    * @param String $courseid Course idate
    * @param int $year Year of addCourse
    * @param char $semester - semester offered
    * @param int $perference - preference night or day
    * @param String $comment - Special comment
    * @param PDO $pdo The Connection
    * @return boolean
    */

    public function RemoveCoursesFromSelection($netId, $courses, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Student)) {
            throw new Exception("Invalid permissions");
        }
        $selectionDAO = new CourseSelectionDAO($pdo);
        $courseSelections = array();
        foreach ($courses as &$course) {
                array_push($courseSelections, CourseSelection::CreateSelection((int) $course['Id'], (int) $course['Year'], $course['Semester'], null, null, false));
        }
        $student = new Student();
        return $selectionDAO->Delete($student->setNetId($netId)
                                             ->setCourses($courseSelections));
    }
    public function AddCourseOffering($netId, $obj, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
        $courseofferings = new CourseOfferingsDAO($pdo);
        $co = new CourseOffering();

        return $courseofferings->Create($co->setId($obj['Id'])->setYear($obj['Year'])->setSemester($obj['Semester']));
    }
    

    /**
    * This removes a courseoffering using the courseofferingDAO - returns true or false on successful execution
    * @param String $netid_id String for permissions
    * @param Course $course course object for parse
    * @param int $year Year of addCourse
    * @param char $semester - semester offered
    * @param PDO $pdo The Connection
    * @return boolean
    */
    public function removeCourseOffering($netid, $course, $year, $semester, PDO &$pdo)
    {
        if (!$this->checkPermissions($netid, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }
        $courseofferings = new CourseOfferingsDAO($pdo);

        $offering = CourseOffering::CreateCourseOffering($course->getId(), $year, $semester);

        return $courseofferings->Delete($offering);
    }

    public function GetUnapprovedCourseOfferingsUnderStudent($netId, $stu_id, PDO &$pdo)
    {
        if (!$this->checkPermissions($netId, $pdo, AccountType::Advisor)) {
            throw new Exception("Invalid permissions");
        }

        $courseSelections = new CourseSelectionDAO($pdo);

        return $courseSelections->Run(new GetUnapprovedCourseSelectionsQuery($stu_id), BaseDAO::All);
    }
}
