<?php
# ----------------------------------------------------------------
# PHP dotenv
# Loads environment variables from .env to getenv()
# accessible with the getenv menthod  eg. getenv('MYSQL_USER');
# ----------------------------------------------------------------
/**
 * Load application environment from .env file
 */
(new \Dotenv\Dotenv(__DIR__ . '/../../'))->load();

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV', 'prod'));
