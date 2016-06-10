<?php


class User
{

    protected $loginId;

    protected $userId;


    public static function create($request = [])
    {
        $query = 'SELECT loginid FROM users WHERE loginid=:loginId';
        $params = [
            'loginId' => $request['loginId']
        ];
        $pdo = new DBFunc();
        $rcv = $pdo->querydb($query, $params);
        if(empty($rcv)){
            $params += [
                'password'=> hash('sha256', $request['password'])
            ];
            $query = 'INSERT INTO users (loginid, password) VALUES (:loginId, :password)';
            $rcv = $pdo->querydb($query, $params);
        }else{
            throw new Exception('帳號重複');
        }
    }

    public static function getAll($page){
        $ItemPerPage = 10;
        $pdo = new DBFunc();
        $query = 'SELECT COUNT(*) AS reccount FROM users';
        $rcv = $pdo->querydb($query, []);
        $reccount = $rcv[0]['reccount'];
        $totalPage = (int) ceil($reccount / $ItemPerPage);
        if($page > $totalPage) $page = $totalPage;
        $start = ($page - 1) * $ItemPerPage;
        $query = "SELECT id, loginid, is_admin, is_valid FROM users ORDER BY id DESC LIMIT $start,$ItemPerPage" ;
        $rcv = $pdo->querydb($query, []);

        $PrevPage = $NextPage = '';
        if ($totalPage > 1) {
            if ($page > 1) $PrevPage = $page - 1;
            if ($page < $totalPage) $NextPage = $page + 1;
        }
        return (empty($rcv)) ? false : [$rcv, $totalPage, $PrevPage, $NextPage];
    }

    public function __construct($loginId)
    {
        $this->loginId = $loginId;
        $pdo = new DBFunc();
        $result = $pdo->querydb('SELECT id FROM users WHERE loginid=:loginId', ['loginId' => $loginId]);
        $this->userId = $result[0]['id'];
    }

    public function addUrl($id)
    {
        $query = 'SELECT * FROM clipboard WHERE user_id=:user_id AND url_id=:url_id';
        $params = [
            'user_id' => $this->userId,
            'url_id' => $id
        ];
        $result = (new DBFunc())->querydb($query, $params);
        if(empty($result)){
            $query = 'INSERT INTO clipboard (user_id, url_id) VALUES (:user_id, :url_id)';
            (new DBFunc())->querydb($query, $params);
        }
    }
    
    public function listUrl($ItemPerPage, $page)
    {
        $pdo = new DBFunc();
        $params = [
            'user_id' => $this->userId
        ];
        $query = 'SELECT COUNT(*) AS reccount FROM url, (SELECT url_id FROM clipboard WHERE user_id=:user_id) as clip WHERE url.id=clip.url_id';
        $rcv = $pdo->querydb($query, $params);
        $reccount = $rcv[0]['reccount'];
        $totalPage = (int) ceil($reccount / $ItemPerPage);
        if($page > $totalPage) $page = $totalPage;
        $start = ($page - 1) * $ItemPerPage;
        $query = "SELECT url.id, url.short, url.expend FROM url, (SELECT url_id FROM clipboard WHERE user_id=:user_id) as clip WHERE url.id=clip.url_id ORDER BY url.id DESC LIMIT $start,$ItemPerPage";
        $rcv = $pdo->querydb($query, $params);

        $PrevPage = $NextPage = '';
        if ($totalPage > 1) {
            if ($page > 1) $PrevPage = $page - 1;
            if ($page < $totalPage) $NextPage = $page + 1;
        }
        return (empty($rcv)) ? false : [$rcv, $totalPage, $PrevPage, $NextPage];
    }
}