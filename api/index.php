<?php

// Set environment variables for Vercel Serverless environment
$_ENV['APP_NAME'] = 'Teh Dandang';
$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'true';
$_ENV['APP_KEY'] = 'base64:78OilwLuaVdZ9hn/SF5j++MPazesVW2EA45ImJi3SC8=';
$_ENV['APP_URL'] = 'https://tehdandang.vercel.app';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['CACHE_DRIVER'] = 'array';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

putenv('APP_ENV=production');
putenv('APP_DEBUG=true');
putenv('APP_KEY=base64:78OilwLuaVdZ9hn/SF5j++MPazesVW2EA45ImJi3SC8=');
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');

// Create required directories in /tmp for Vercel serverless execution
$dirs = ['/tmp/views', '/tmp/storage/framework/views', '/tmp/storage/framework/sessions', '/tmp/storage/framework/cache', '/tmp/storage/logs'];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Forward Vercel requests to Laravel entrypoint
require __DIR__ . '/../public/index.php';
