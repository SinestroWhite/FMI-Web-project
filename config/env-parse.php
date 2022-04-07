<?php

/*
|--------------------------------------------------------------------------
| Register The Environmental Variables
|--------------------------------------------------------------------------
|
| Load the variables from the .env file into memory.
|
*/

$filename = "../.env";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
/* TODO: Handle error */
fclose($handle);

$arr = explode("\n", $contents);

foreach ($arr as $item) {
    $data = explode("=", $item);
    $_ENV[$data[0]] = $data[1];
}
