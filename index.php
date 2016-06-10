<?php

session_start();
require_once __DIR__ . '/classes/autoload.php';
if(isset($_SESSION['Auth'])){
    $Auth=unserialize($_SESSION['Auth']);
}
if(isset($_SESSION['User'])){
    $User = unserialize($_SESSION['User']);
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['e'])){
        $shortUrl = new ShortUrl();
        $expend = $shortUrl->shortToUrl($_GET['e']);
        if(isset($expend)){
            header('Location: ' . $expend);
        }else{
            header('Location: .');
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['webAddress'])){
        try{
            $short = '';
            $id = '';
            $shortUrl = new ShortUrl();
            list($short, $id) = $shortUrl->urlToShort($_POST['webAddress']);
            if(isset($Auth)){
                $isLogin = $Auth->isLogin();
                if($isLogin){
                    $User->addUrl($id);
                }
            }
        }catch (Exception $e){
            $ErrMsg = $e->getMessage();
        }
    } else {
        $ErrMsg = '你黑黑 你全家都黑黑';
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

    <title>短網址</title>

    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        div{
            display: block;
        }

        h2{
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }


        .form-shortWebAddress {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>

</head>
<body>
<?php require_once 'nav.php'?>

<div class="container" style="padding-top: 60px">
    <form class="form-shortWebAddress" method="POST" action="">
        <fieldset class="form-group">
            <label for="webAddress">原始網址</label>
            <input type="text" class="form-control" id="webAddress" name="webAddress"
            >
        </fieldset>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- 顯示短網址 start -->
    <h2><?php
        if (isset($ErrMsg)){
            echo $ErrMsg;
        } else if (isset($short)){
            echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?e=' . $short;
        }
        ?></h2>        <!-- 顯示短網址 end -->
</div>
</body>
</html>