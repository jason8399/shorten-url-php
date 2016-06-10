<?php

class Auth
{

    protected $id;

    protected $loginId;

    protected $is_admin;

    protected $is_valid;

    protected $is_login;
    
    protected $ErrMsg;


    public function __construct($loginId, $password)
    {
        $this->loginId = $loginId;
        $this->ErrMsg = '';
        $this->is_login = false;
        $this->__login($password);
    }

    private function __login($password)
    {
        $query = 'SELECT * FROM users WHERE loginId=:loginId';
        $params = ['loginId' => $this->loginId];
        $pdo = new DBFunc();
        $rcv = $pdo->querydb($query, $params);
        if (strlen($this->loginId) > 0 && strlen($this->loginId) <= 16
            && $this->loginId == addslashes($this->loginId)){
            if (count($rcv) > 0){
                if (!$is_correct = ((hash('sha256', $password) == $rcv[0]['password']))){
                    $this->ErrMsg .= 'Password Error</br>';
                }
                $this->id = $rcv[0]['id'];
                $this->is_admin = ($rcv[0]['is_admin'] == 'Y') ? true : false;
                $this->is_valid = ($rcv[0]['is_valid'] == 'Y') ? true : false;
                if($this->is_valid && $is_correct) $this->is_login = true;
                else $this->ErrMsg .= '您並非合法使用者或是使用權已被停止</br>';
            }
        } else {
            $this->ErrMsg .= 'ID錯誤，您並非合法使用者或是使用權已被停止';
        }
    }
    
    public function getLoginId()
    {
        return $this->loginId;
    }
    
    public function isLogin()
    {
        return $this->is_login;
    }
    
    public function isValid()
    {
        return $this->is_valid;
    }
    
    public function isAdmin()
    {
        return $this->is_admin;
    }
    
    public function getErrMsg()
    {
        return $this->ErrMsg;
    }
}