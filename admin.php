<?php
session_start();
require_once __DIR__ . '/classes/autoload.php';
require_once 'check.php';
if (!$Auth->isAdmin()){
    echo "permission deny";
    header('Location:index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['page'])){
        $page = intval($_GET['page']);
        if ($page < 1)
            $page = 1;
    } else {
        $page = 1;
    }
}

list($url, $totalPage, $prePage, $nextPage) = User::getAll($page);

function createTR($item){
    echo '<tr>';
    $id = $item['id'];
    $loginid = $item['loginid'];
    $isAdmin = $item['is_admin'];
    $isValid = $item['is_valid'];
    echo "<td>$id</td>";
    echo "<td>$loginid</td>";
    echo "<td>$isAdmin</td>";
    echo "<td>$isValid</td>";
    echo "<td>
<a href='disableUser?id=$id'>停權</a>
<a href='permission.php?id=$id'>提升為管理員</a>
</td>";
    echo '</tr>';
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>管理介面</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        div{
            display: block;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin .checkbox {
            font-weight: normal;
        }
        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        [class*="col-"] {
            padding-top: 15px;
            padding-bottom: 15px;
            background-color: #eee;
            background-color: rgba(86,61,124,.15);
            border: 1px solid #ddd;
            border: 1px solid rgba(86,61,124,.2);
        }
        .row .row {
            margin-top: 10px;
            margin-bottom: 0;
        }
        .row {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navgation">
    <div class="container">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Admin</a></li>
                <li><a href="logout.php">登出</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container" style="padding-top: 60px">
    <div class="row">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th class="active">id</th>
                <th class="success">帳號</th>
                <th class="warning">管理員</th>
                <th class="danger">停權</th>
                <th class="info">操作</th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach($url as $value){
                createTR($value);
            }
            ?>
            </tbody>

        </table>
    </div>
</div>
</body>
</html>