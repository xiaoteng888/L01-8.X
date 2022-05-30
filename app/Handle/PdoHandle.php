<?php


namespace App\Handle;


class PdoHandle
{
    public $source;

    private $driver;
    private $host;
    private $dbname;
    private $username;
    private $password;

    /**
     * PdoHandle constructor.
     */
    public function __construct($driver = 'mysql', $host = 'localhost', $dbname = 'kaijiang', $username = 'homestead', $password = 'secret')
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $dsn = $this->driver . ':host=' . $this->host . ';dbname=' . $this->dbname;
        $this->source = new \PDO($dsn, $this->username, $this->password);
        $this->source->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
