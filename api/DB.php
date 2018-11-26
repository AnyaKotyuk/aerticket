<?php
/**
 * Class DB
 * Work with database easier
 *
 */

class DB{
    private static $instance = null;
    private $USER = 'root';
    private $PASSWORD = 'pass';
    private $DATABASE = 'aer';
    private $HOST = 'mysql';
    private $connection;

    /**
     * Create DB connection
     */
    private function __construct()
    {
        $this->connection = new PDO(
            'mysql:host='.$this->HOST.';dbname='.$this->DATABASE,
            $this->USER, $this->PASSWORD)
        or die('Connection error');
    }

    /**
     * Get instance
     *
     * @return DB|null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Query prepared sql
     *
     * @param $q
     * @return mixed
     */
    public function prepare_query($q, $params = null)
    {
        $res = $this->connection->prepare($q)->execute($params);
        if ($res === false) die ('Query error!');
        return $res;
    }

    /**
     * Query sql
     *
     * @param $q
     * @return mixed
     */
    public function query($q)
    {
        $res = $this->connection->query($q);
        if ($res === false) die ('Query error!');
        return $res;
    }

    /**
     * Query select
     *
     * @param $q
     * @return mixed
     */
    public function db_query_select($q)
    {
        $res = $this->connection->query($q);
        if ($res === false) die ('Query error!');
        $result = $res->fetchAll();
        return $result;
    }

    public function db_query_count($q)
    {
        $res = $this->connection->query($q);
        if ($res === false) die ('Query error!');
        $result = $res->rowCount();
        return $result;
    }
}
