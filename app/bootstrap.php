<?php
declare(strict_types=1);


// SETUP PATH ALIASES
// ----------------------------------------------------------------------

define('ROOT_DIR', buildPath(getcwd(), '/..'));
define('DATA_DIR', buildPath(ROOT_DIR, '/data'));
define('ROUTES_DIR', buildPath(ROOT_DIR, '/src/routes'));
define('MIDDLEWARE_DIR', buildPath(ROOT_DIR, '/src/middleware'));


// TODO: finish mapping these macro path helpers
function root_path($filepath)   { return buildPath(ROOT_DIR, $filepath); }
function logs_path($filepath)   { return buildPath(ROOT_DIR, '/logs', $filepath); }
function data_path($filepath)   { return buildPath(ROOT_DIR, '/data', $filepath); }
function public_path($filepath) { return buildPath(ROOT_DIR, '/public', $filepath); }
function storage_path($filepath) { return buildPath(ROOT_DIR, '/public', $filepath); }



// DEV LOAD ENVIRONMENT
// ----------------------------------------------------------------------

$dotenv = Dotenv\Dotenv::create(ROOT_DIR);
// $dotenv->load();
$dotenv->overload();

$dotenv->required([
    'APP_ENV',
    'APP_HOSTNAME',
    'APP_TIMEZONE',
    'APP_TITLE',
    'DB_DATABASE',
    'DB_HOSTNAME',
    'JWT_ALGORITHM',
    'JWT_SECRET',
    'JWT_SECRET',
]);



// DEFINE ENVIRONMENT CONSTANTS
// ----------------------------------------------------------------------

$IS_DEV = env('APP_ENV') !== 'production';

define('IS_DEV',  $IS_DEV);
define('IS_PROD', !$IS_DEV);



// SET SERVER CONFIGS
// ----------------------------------------------------------------------

date_default_timezone_set(env('APP_TIMEZONE'));



// DEV RUN WHOOPS!
// ----------------------------------------------------------------------

$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
