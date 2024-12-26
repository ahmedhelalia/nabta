<?php
include 'config/init.php';
session_destroy();
header('location:'.ROOT);
die();