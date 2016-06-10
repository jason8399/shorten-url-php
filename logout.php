<?php
session_start();
session_unset();
header('refresh:5;url=index.php');
echo '已登出，5秒後自動轉跳';

