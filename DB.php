<?php

class DB
{
    protected static $instance = null;

    protected $host, $db, $username, $password, $charset, $opt, $dsn, $dbh;

    public function __construct()
    {
        if (! defined('CONFIG_DB')) {
            throw new Exception('CONFIG_DB constant is not set');
        }

        $conf = require_once CONFIG_DB;

        $this->host = $conf['host'];
        $this->db = $conf['db'];
        $this->username = $conf['username'];
        $this->password = $conf['password'];
        $this->charset = $conf['charset'];
        $this->opt = $conf['opt'];

        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";

        $this->dbh = new PDO($this->dsn, $this->username, $this->password, $this->opt);
    }

    /**
     * Returns an object with a connected database
     *
     * @return DB
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Run a dry query
     *
     * @param string $sql
     * @return DB
     */
    public function query(String $sql): self
    {
        $this->stmt = $this->dbh->query($sql);

        return $this;
    }

    /**
     * Executing a query with variables
     *
     * @param string $sql
     * @param array $param
     * @return DB
     */
    public function queryWithPrepare(String $sql, Array $param): self
    {
        $this->stmt = $this->dbh->prepare($sql);

        $this->execute($param);

        return $this;
    }

    /**
     * Run a query with parameters
     *
     * @param array $param
     * @return void
     */
    private function execute(Array $param): void
    {
        $this->stmt->execute($param);
    }

    /**
     * Fetch Data
     *
     * @return array
     */
    public function fetch(): array
    {
        return $this->stmt->fetch();
    }

    /**
     * Fetch All Data
     *
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->stmt->fetchAll();
    }
}
