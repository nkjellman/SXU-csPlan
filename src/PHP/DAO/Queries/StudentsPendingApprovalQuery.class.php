<?php
require_once 'IQuery.interface.php';
class StudentsPendingApprovalQuery implements IQuery
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
        $stmt = $pdo->prepare("SELECT A.* FROM advising A JOIN course_selections CS ON CS.net_id = A.student WHERE approved = 0 AND advisor = ? GROUP BY student");
        $stmt->execute(array($this->NetId));
        return $stmt;
    }
}


