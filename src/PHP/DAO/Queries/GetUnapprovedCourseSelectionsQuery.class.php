<?php
require_once 'IQuery.interface.php';
class GetUnapprovedCourseSelectionsQuery implements IQuery
{
    private $NetId;

    public function __construct($netId)
    {
        if (!is_string($netId)) {
            throw new InvalidArgumentException("Invalid net_id");
        }


        $this->NetId = $netId;
        
    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("SELECT C.course_id, C.course_num, D.abbreviation, C.name, CO.semester, CO.year FROM course_selections CS
								JOIN course_offerings CO ON CO.course_id = CS.course_id AND CO.semester = CS.semester AND CO.year = CS.year
                               JOIN courses C ON CO.course_id = C.course_id
							   JOIN departments D ON C.dept_id = D.dept_id
                               WHERE CS.approved = 0 AND net_id = ?");
        $stmt->execute(array($this->NetId));
        return $stmt;
    }
}