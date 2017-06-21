<?php

namespace IVAgafonov\System;

/**
 * Class DataProvider
 * @package IVAgafonov\System
 */
class DataProvider implements DataProviderInterface
{
    /**
     * PDO object
     *
     * @var \PDO
     */
    private $db;

    /**
     * PDO Statement object
     *
     * @var \PDOStatement
     */
    private $statement;

    /**
     * DataProvider constructor.
     *
     * @param array $config Config PDO
     *  $config = [
     *      'dbHost' => (string) DB host
     *      'dbName' => (string) DB name
     *      'dbUser' => (string) DB user
     *      'dbPass' => (string) DB password
     *  ]
     *
     * @throws \Exception
     */
    public function __construct($config)
    {
        if (empty($config['dbHost']) || empty($config['dbName']) || empty($config['dbUser']) || !isset($config['dbPass'])) {
            throw new \Exception("Invalid database params");
        }
        $this->db = new \PDO("mysql:dbname=".$config['dbName'].";host=".$config['dbHost'].";charset=utf8", $config['dbUser'], $config['dbPass']);
    }

    /**
     * Get objects by sql query
     *
     * @param string $query  Sql query
     * @param string $object Object name
     *
     * @return array|bool
     */
    public function getObjects($query, $object)
    {
        $this->statement = $this->db->query($query);
        if ($this->statement) {
            $this->statement->setFetchMode(\PDO::FETCH_CLASS, $object);
            $objects =  $this->statement->fetchAll();
            if ($objects) {
                return $objects;
            }
        }
        return false;
    }

    /**
     * Get object by sql query
     *
     * @param string $query  Sql query
     * @param string $object Object name
     *
     * @return array|bool
     */
    public function getObject($query, $object)
    {
        $this->statement = $this->db->query($query);
        if ($this->statement) {
            $this->statement->setFetchMode(\PDO::FETCH_CLASS, $object);
            return $this->statement->fetch();
        }
        return false;
    }

    /**
     * Get arrays by sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function getArrays($query)
    {
        $this->statement = $this->db->query($query);
        if ($this->statement) {
            $result =  $this->statement->fetchAll(\PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            }
        }
        return false;
    }

    /**
     * Get array by sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function getArray($query)
    {
        $this->statement = $this->db->query($query);
        if ($this->statement) {
            return $this->statement->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Get array by sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function getValue($query)
    {
        $this->statement = $this->db->query($query);
        if ($this->statement) {
            $value = $this->statement->fetch(\PDO::FETCH_BOTH);
            if (!empty($value[0])) {
                return $value[0];
            }
        }
        return false;
    }

    /**
     * Execute sql query
     *
     * @param string $query Sql query
     *
     * @return array|bool
     */
    public function doQuery($query)
    {
        $this->statement = $this->db->query($query);
        if ($this->statement && $this->statement->rowCount()) {
            return $this->statement->rowCount();
        }
        return false;
    }

    /**
     * Quote string
     *
     * @param string $str Text string
     *
     * @return string
     */
    public function quote($str)
    {
        return $this->db->quote($str);
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        if ($this->statement) {
            return $this->statement->rowCount();
        }
        return false;
    }

    /**
     * @return string
     */
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @return array
     */
    public function getLastError()
    {
        return $this->db->errorInfo();
    }

    /**
     * @return mixed
     */
    public function getLastErrno()
    {
        return $this->db->errorCode();
    }
}
