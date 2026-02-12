<?php
$env = json_decode(file_get_contents('./env.json'));

$db = mysqli_connect($env->servername, $env->username, $env->password, $env->dbname);

if (!$db) {
    echo "Connection to database failed.";

} else {
    echo "Connected to database...";
}