<?php
require_once __DIR__.'/../Models/Account.class.php';
require_once 'BaseDAO.class.php';

class AccountDAO extends BaseDAO
{
    public function __construct(PDO &$pdo)
    {
        parent::__construct($pdo);
    }
  
    public function Create($model)
    {
        return parent::Execute("INSERT INTO accounts (net_id, first_name, last_name, type, email, picture) VALUES (?, ?, ?, ?, ?, ?);",
                           array($model->getNetId(), $model->getName()->getFirst(), $model->getName()->getLast(), $model->getType(), $model->getEmail(), $model->getImage()));
    }
    public function Delete($model)
    {
        return parent::Execute($this->QueryMatch("DELETE FROM accounts", $model));
    }
    protected function QueryMatch($stmt, $model)
    {
        if (is_null($model)) {
            throw new InvalidArgumentException("Null exception");
        }
        $sql = "$stmt WHERE 1=1 ";
        if ($model->getNetId() !== null) {
            $sql .= "AND net_id = '".$model->getNetId()."' ";
        }
        if ($model->getName() !== null) {
            if ($model->getName()->getFirst() !== null) {
                $sql .= "AND first_name = '".$model->getName()->getFirst()."' ";
            }
            if ($model->getName()->getLast() !== null) {
                $sql .= "AND last_name = '".$model->getName()->getLast()."' ";
            }
        }
        if ($model->getType() !== null) {
            $sql .= "AND type = ".$model->getType()." ";
        }
        if ($model->getEmail() !== null) {
            $sql .= "AND email = '".$model->getEmail()."' ";
        }
        return $sql;
    }
    public function Read($model, $fetch, $stmt = null, $result = null)
    {
        if ($stmt == null) {
             $stmt = "SELECT * FROM accounts";
        }
        if ($result == null) {
             $result = parent::Fetch($this->QueryMatch($stmt, $model), $fetch);
        }
        if ($result === false) {
            return null;
        }
        switch ($fetch) {
            case parent::Single:
                $model->setNetId($result['net_id'])
                      ->setName(new Name($result['first_name'], $result['last_name']))
                      ->setType((int)$result['type']);
                if (!is_null($result['email'])) {
                    $model->setEmail($result['email']);
                }
                if (!is_null($result['picture'])) {
                    $model->setImage($result['picture']);
                }
                return $model;
            case parent::All:
                $array = array();
                foreach ($result as $row) {
                    array_push($array, Account::CreateAccount($row['net_id'], new Name($row['first_name'], $row['last_name']),
                        array_key_exists('type', $row) ? (int) $row['type'] : null,
                        array_key_exists('email', $row) ?  $row['email'] : null,
                        array_key_exists('picture', $row) ?  $row['picture'] : null));
                }
                return $array;
            default:
                throw new InvalidArgumentException("You're not supposed to be here...");
        }
    }
    public function Update($model)
    {
        return parent::Execute("UPDATE accounts SET first_name=?, last_name=?, type=?, email=?, picture=? WHERE net_id=?;",
                               array($model->getName()->getFirst(), $model->getName()->getLast(), $model->getType(),  $model->getEmail(), $model->getImage(), $model->getNetId()));
    }
}
