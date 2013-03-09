<?php

function autoload($className)
{
	$className = ltrim($className, '\\');
	$fileName = '';
	$namespace = '';
	if ($lastNsPos = strripos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
	require strtolower($fileName);
}

spl_autoload_register('autoload');

$core = new MedWave\Core\System();
$db = $core->getDbcon();

?>
<!DOCTYPE html>
<html>
<head>
	<title>MedWave | Waves for the Future</title>
</head>
<body>
	<div class="wrapper_content">
		<header></header>
		<div class="content">
			This is just some content to showcase that this is working.
		</div>
		<footer></footer>
	</div>
</body>
</html>
