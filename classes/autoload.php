<?php
//autoload.php
function __autoload($classname)
{
	$filename = __DIR__ . '/' . $classname . ".php";
	
	if (is_readable($filename)) {
		require $filename;
	}
}
