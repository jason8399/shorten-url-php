<?php
if(isset($_SESSION['Auth'])){
    $Auth=unserialize($_SESSION['Auth']);
} else {
    die('Not Login');
}
if(isset($_SESSION['User'])){
    $User = unserialize($_SESSION['User']);
}
