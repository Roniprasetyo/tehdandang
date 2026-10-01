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

putenv('APP_ENV=production');
putenv('APP_DEBUG=true');
putenv('APP_KEY=base64:78OilwLuaVdZ9hn/SF5j++MPazesVW2EA45ImJi3SC8=');
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

// Create required directories in /tmp for Vercel serverless execution
if (!is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0777, true);
}

// Forward Vercel requests to Laravel entrypoint
require __DIR__ . '/../public/index.php';
