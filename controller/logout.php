<?php
session_start();
session_destroy();

header("Location: ../contents/login.php");
