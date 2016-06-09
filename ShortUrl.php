<?php

class ShortUrl
{

    protected static $char="Mqv4I6F2jYsTJufBbVGRLmSk8Ole0nErycPpU3tWzX17D5aA9oKwixHghCQdZN";
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new DBFunc();
    }

    public function urlToShort($url)
    {
        if (empty($url)){
            throw new Exception("No URL supplied");
        }

        if (!$this->validateUrl($url)){
            throw new Exception("Not valid url format");
        }
        
        $short = $this->urlExisted($url);
        if(!$short){
            $short = $this->createShort($url);
        }
        
        return $short;
    }

    protected function validateUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    protected function urlExisted($url)
    {
        $query = 'SELECT short FROM url WHERE expend=:expend';
        $params = array('expend' => $url);
        $result = $this->pdo->querydb($query, $params);
        return (empty($result)) ? false : $result[0]['short'];
    }

    protected function insertUrl($url)
    {
        $query = 'INSERT INTO url (expend) VALUES (:expend)';
        $params = array('expend' => $url);
        $this->pdo->querydb($query, $params);
        return $this->pdo->lastInsertId();
    }

    protected function convertIntToShort($id)
    {
        $id = intval($id);
        $length = strlen(ShortUrl::$char);
        $short = '';
        while ($id > $length - 1){
            $short .= $id % $length;
            $id = floor($id / $length);
        }
        $short = ShortUrl::$char[$id] . $short;
        return $short;
    }

    protected function insertShort($id, $short)
    {
        $query = "UPDATE url SET short=:short WHERE id=:id";
        $params = array('short' => $short, 'id' => $id);
        $stat = $this->pdo->updatedb($query, $params);
        if($stat->rowCount() < 1)
            throw new Exception('Update error');
        return true;
    }

    protected function createShort($url)
    {
        $id = $this->insertUrl($url);
        $short = $this->convertIntToShort($id);
        $this->insertShort($id, $short);
        return $short;
    }
}