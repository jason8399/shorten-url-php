<?php

require_once __DIR__ . '/classes/autoload.php';

session_start();

$ErrMsg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['loginId']) && isset($_POST['password']) && isset($_POST['passwordConfirm'])){
        extract($_POST, EXTR_OVERWRITE);
        if(strlen($loginId) > 0 && strlen($loginId) <= 16 && $loginId == addslashes($loginId)){
            if(strlen($password) > 4&& strlen($password) <= 16 &&
                strlen($passwordConfirm) > 4 && strlen($passwordConfirm) <= 16){
                if($password == $passwordConfirm){
                    try{
                        User::create(['loginId'=>$loginId, 'password'=>$password]);
                        $_SESSION['message'] = '註冊成功';
                        header('Location: login.php');
                    }catch (Exception $e){
                        $ErrMsg = $e->getMessage();
                    }
                } else {
                    $ErrMsg = '密碼不一致';
                }
            } else {
                $ErrMsg = '密碼長度請介於5~16碼之間';
            }
        } else {
            $ErrMsg = '帳號為空或超過限制';
        }
    } else {
        $ErrMsg = '資料未填寫完整';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <title>註冊</title>

    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        div{
            display: block;
        }

        .form-register {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navgation">
    <div class="container">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="login.php">登入</a></li>
                <li class="active"><a href="#">註冊</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container" style="padding-top: 60px">
    <?php
    if(!empty($ErrMsg)){
        echo "<div class=\"alert alert-danger\" role=\"alert\">$ErrMsg</div>";
    }
    ?>
    <form class="form-register" action="" method="post">
        <fieldset class="form-group">
            <label for="accountNumber">帳號</label>
            <input type="text" class="form-control" id="accountNumber" name="loginId">
        </fieldset>

        <fieldset class="form-group">
            <label for="password">密碼</label>
            <input type="password" class="form-control" id="password" name="password">
        </fieldset>

        <fieldset class="form-group">
            <label for="passwordAgain">再重複一次密碼</label>
            <input type="password" class="form-control" id="passwordAgain" name="passwordConfirm">
        </fieldset>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
