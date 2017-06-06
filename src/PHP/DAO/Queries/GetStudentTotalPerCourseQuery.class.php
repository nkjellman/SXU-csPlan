<?php
require_once 'IQuery.interface.php';
class GetStudentTotalPerCourseQuery implements IQuery
{
    public function __construct()
    {
    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("SELECT CO.*,C.*,COUNT(CS.net_id) total FROM course_offerings CO JOIN courses C ON CO.course_id = C.course_id LEFT JOIN course_selections CS ON CO.course_id = CS.course_id AND CO.semester = CS.semester AND CO.year =CS.year GROUP BY CO.course_id, CO.year,CO.semester");
        $stmt->execute(array());
        return $stmt;
    }
}
