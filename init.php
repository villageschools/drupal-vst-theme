<?php

    date_default_timezone_set(SITE_TIMEZONE);
    ini_set('display_errors', DEBUG ? 1 : 0);
    set_error_handler("handle_error");

?>