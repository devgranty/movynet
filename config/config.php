<?php
/*
 | ---------------------------------------
 | KEYWORDS DEFINITION AND CONFIGURATION
 | ---------------------------------------
 |
 | Lets define all keywords and setup
 | all configurations used in the entire
 | application.
 |
 | ---------------------------------------
 | NOTE!
 | ---------------------------------------
 | 
 | Setting an invalid or incorrect value or
 | configuration might break the enire 
 | application, be sure to know what you
 | are doing.
 |
 */

# Site default app name or site name.
define('SITE_NAME', 'Movynet');

# Define site scheme://domain.
define('SITE_URL', 'http://localhost');

# Site root folder after the "http://localhost".
define('SROOT', '/projects/movynet/');

# Admin root folder after the "http://localhost".
define('AROOT', '/projects/movynet/admin/');

# Configure database connection settings
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'movyghcx_movynet_db');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

# Default timezone used. Make sure to refer to the PHP manual before making changes.
define('SET_TIMEZONE', 'Africa/Lagos');

# Define TMDB API. (used for this particular app)
define('TMDB_API_KEY', 'ffc8f5a4954822a32460194c76cd8dd7');
define('TMDB_IMG_BASE_URL', 'https://image.tmdb.org/t/p/');
define('PS', 'w92');
define('PS2', 'w154');
define('BS', 'w780');
