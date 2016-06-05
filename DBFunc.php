<?php

class DBFunc extends PDO
{
    protected $pdo;

    public function __construct($file = 'config.ini')
    {
        if (!$settings = parse_ini_file($file))
            throw new Exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ';dbname=' . $settings['database']['schema'];

        parent::__construct($dns, $settings['database']['useranem'], $settings['database']['password']);
    }

    public function querydb($query, $params)
    {
        $stmt = $this->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }


}