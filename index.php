<?php

require_once __DIR__ . '/autoload.php';

$get = '';

$test = new ShortUrl();
echo $test->urlToShort('http://140.129.25.119:9622');

?>
