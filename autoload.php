<?php
//autoload.php
function __autoload($classname)
{
	$filename = __DIR__ . "/classes/" . $classname . ".php";
	if (is_readable($filename)) {
		require $filename;
	}
}
