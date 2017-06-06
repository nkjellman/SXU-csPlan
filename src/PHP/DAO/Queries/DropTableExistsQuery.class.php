<?php
require_once 'IQuery.interface.php';
class DropTableExistsQuery implements IQuery
{
    public function __construct()
    {
    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("DROP TABLE IF EXISTS test, slope,linreg,years,lastsem,numStudents,e,e2,em,c,sum1,sum2,output; ");
                $stmt->execute(array());

        return $stmt;
    }
}
