<?php

class DBFunc extends PDO
{
    protected $pdo;

    public function __construct($file = 'config.ini')
    {
        if (!$settings = parse_ini_file($file))
            throw new Exception('Unable to open ' . $file . '.');
        $dns = $settings['driver'] .
            ':host=' . $settings['host'] .
            ';dbname=' . $settings['dbname'];

        parent::__construct($dns, $settings['username'], $settings['password']);
    }

    public function querydb($query, $params)
    {
        $stmt = $this->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updatedb($query, $params)
    {
        $stmt = $this->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}