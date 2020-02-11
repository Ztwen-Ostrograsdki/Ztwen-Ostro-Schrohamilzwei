<?php
session_destroy();
$_SESSION = [];
header('Location:'.$_SERVER['HTTP_REFERER']);
