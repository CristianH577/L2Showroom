<?php
error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

ini_set('ignore_repeated_errors', TRUE); // always use TRUE

ini_set('display_errors', FALSE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment

ini_set('log_errors', TRUE); // Error/Exception file logging engine.

ini_set("error_log", "php-error.log");
error_log( "Inicio de aplicacion web" );

require_once 'libs/database.php';

require_once 'libs/controller.php';
require_once 'libs/view.php';
require_once 'libs/model.php';
require_once 'libs/app.php';

require_once 'classes/session.php';
require_once 'classes/session_controller.php';
require_once 'classes/errors_messages.php';
require_once 'classes/success_messages.php';

require_once 'config/config.php';

include_once 'models/usermodel.php';

$app = new App();
?>