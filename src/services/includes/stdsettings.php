<?php

date_default_timezone_set("Asia/Calcutta");

// Json Response Constants
define("SUCCESS", 200); //Success response code
define("WARNING", 300); //Warning response code
define("FAILED", 400); //Failed response code

// DB Constants
define("DB_HOSTNAME", "localhost");
define("DB_NAME", "itccam5_schoolAdmission");
define("DB_USERNAME", "itccam5_itccamp");
define("DB_PASSWORD", "AppiLaryC406#");

// Create DB Connection
$dbConn = new DBConnection(constant("DB_NAME"), constant("DB_USERNAME"), constant("DB_PASSWORD"));

$SITE_PATH = '/home/itccam5/public_html';
$VMP_AB_PATH = $SITE_PATH . "/school-admission/services";
