<?php
require_once 'IQuery.interface.php';
class GetTotalCreditsQuery implements IQuery
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
        $stmt = $pdo->prepare("SELECT SUM(C.credit_hours) AS Credits FROM csplan_develop.course_selections CS JOIN courses C ON C.course_id = CS.course_id WHERE approved = 1 AND net_id = ?");
        $stmt->execute(array($this->NetId));
        return $stmt;
    }
}
