<?php
require_once 'IQuery.interface.php';
class SearchCoursesPerPreReq implements IQuery
{
    private $NetId,
            $Semester,
            $Year;
    public function __construct($netId, $semester, $year)
    {
        if(!is_string($netId)) throw new InvalidArgumentException("Invalid net id");
        if(!is_string($semester)) throw new InvalidArgumentException("Invalid semester");
        if(!is_int($year)) throw new InvalidArgumentException("Invalid year");
        $this->NetId = $netId;
        $this->Semester = $semester;
        $this->Year = $year;
    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("SELECT Z.course_id, Z.dept_id, Z.course_num, Z.name, z.description, CO.year, CO.semester, Z.credit_hours, Z.elective FROM(SELECT C.* FROM courses C LEFT JOIN prerequisites P ON C.course_id = P.course_id WHERE P.prereq_id IS NULL UNION SELECT C.* FROM(SELECT P.course_id, Count(*) AS count FROM prerequisites P GROUP BY P.course_id) P1 JOIN(SELECT P.course_id, Count(*) AS count FROM prerequisites P JOIN course_selections CS ON CS.course_id = P.prereq_id AND CS.net_id = ? GROUP BY P.course_id) P2 ON P1.course_id = P2.course_id AND P1.count = P2.count JOIN courses C ON C.course_id = P1.course_id) Z JOIN course_offerings CO ON CO.course_id = Z.course_id AND CO.semester = ? AND CO.year = ? LEFT JOIN (SELECT * FROM course_selections WHERE net_id = ? AND approved = 1) tCS ON tCS.course_id = Z.course_id WHERE tCS.net_id IS NULL ");
        $stmt->execute(array($this->NetId,$this->Semester, $this->Year,$this->NetId));
        return $stmt;
    }
}
