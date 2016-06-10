<?php
session_start();
require_once __DIR__ . '/classes/autoload.php';
require_once 'check.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page = 1;
    }
}

list($url, $totalPage, $prePage, $nextPage) = $User->listUrl(10,$page);
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

    <title>歷史紀錄</title>

    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        div{
            display: block;
        }
    </style>
</head>
<body>
<?php
require_once 'nav.php';
?>
<div class="container" style="padding-top: 60px">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="active">原始網址</th>
            <th class="success">短網址</th>
            <th class="danger">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($url)){
            foreach($url as $value){
                echo '<tr>';
                echo '<td class="active"><a href="' . $value['expend'] . '">' . $value['expend'] . '</a></td>';
                $shortUri = 'http://140.129.25.119:9605/project/?e=' . $value['short'];
                echo "<td class=\"success\"><a href='$shortUri'>$shortUri</a></td>";
                echo '<td class="danger"><a href="deleteClip.php?id=' . $value['id'] . '">刪除</td>';
                echo '</tr>';
            }
        }
        else
            echo '<tr><td>沒有資料喔</td><td>沒有資料喔</td></tr>'
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
