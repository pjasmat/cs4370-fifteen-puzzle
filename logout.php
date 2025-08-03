<?php
require 'db.php';

session_unset();
session_destroy();

header("Location: index2.php");
exit;
