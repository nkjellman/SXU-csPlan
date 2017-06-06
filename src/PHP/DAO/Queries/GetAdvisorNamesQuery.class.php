<?php
require_once 'IQuery.interface.php';
class GetAdvisorNamesQuery implements IQuery
{
    private $NetId;
    public function __construct()
    {

    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("SELECT net_id,first_name,last_name  FROM accounts WHERE type = 2");
        $stmt->execute();
        return $stmt;
    }
}
