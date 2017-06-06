<?php
require_once 'IDAO.interface.php';

abstract class BaseDAO implements IDAO
{
    protected $PDO;
    const Single = 1,
          All = 2;
    protected function __construct(PDO &$pdo)
    {
        if (is_null($pdo)) {
            throw new InvalidArgumentException("Invalid argument");
        }
        $this->PDO = $pdo;
    }
    abstract public function Create($model);
    abstract public function Read($model, $fetch, $stmt = NULL, $result = NULL);
    abstract public function Update($model);
    abstract public function Delete($id);
    abstract protected function QueryMatch($stmt, $model);

    protected function Fetch($statement, $amount)
    {
        if (!is_string($statement) && !($statement instanceof PDOStatement)) {
            throw new InvalidArgumentException('Invalid statement input');
        }
        if (!is_int($amount)) {
            throw new InvalidArgumentException("Invalid amount enum");
        }
        $pdoStmt = ($statement instanceof PDOStatement) ? $statement : $this->PDO->query($statement);
        switch ($amount) {
            case self::Single:
                return $pdoStmt->fetch(PDO::FETCH_ASSOC);
            case self::All:
                return $pdoStmt->fetchAll(PDO::FETCH_ASSOC);
            default:
                throw new Exception("Not a valid enum value");
        }
    }
    protected function Execute($statement, array $params = null)
    {
        if (!is_string($statement)) {
            throw new InvalidArgumentException('Invalid statement input');
        }
        return (is_null($params)) ? $this->PDO->prepare($statement)->execute() : $this->PDO->prepare($statement)->execute($params);
    }
    public function Find(IQuery $query)
    {
        return $this->Read(NULL,self::All,NULL,$this->Fetch($query->getQuery($this->PDO),self::All));
    }
    public function Run(IQuery $query, $type) {
        if (!is_int($type)) {
            throw new Exception("Invalid Type");
        }
        return $this->Fetch($query->getQuery($this->PDO), $type);
    }
}
