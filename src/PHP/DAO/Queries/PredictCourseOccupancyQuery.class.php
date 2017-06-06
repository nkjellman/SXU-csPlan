<?php
require_once 'IQuery.interface.php';
class PredictCourseOccupancyQuery implements IQuery
{
    public function __construct()
    {
    }
    public function getQuery(&$pdo)
    {
        $stmt = $pdo->prepare("CALL spPredictCourseOccupancy;");
                $stmt->execute(array());

        return $stmt;
    }
}
