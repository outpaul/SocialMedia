<?php

$link = new mysqli("localhost","root","I know it","VirtualIdentity");

if($link === false)
	die("ERROR: Could not connect to the database.".$link->connect_error);

?>
