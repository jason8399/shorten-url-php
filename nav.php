<nav class="navbar navbar-inverse navbar-fixed-top" role="navgation">
    <div class="container">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">短網址</a></li>
                <?php
                if(isset($Auth)){
                    $login = $Auth->isLogin();
                    $admin = $Auth->isAdmin();
                    if($login){
                        echo '
                <li><a href="history.php">歷史紀錄</a></li>
                <li><a href="logout.php">登出</a></li>';
                    }
                    if($admin){
                        echo '
                        <li><a href="admin.php">管理</a></li>
                        ';
                    }
                } else {
                    echo '
                <li><a href="login.php">登入</a></li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>