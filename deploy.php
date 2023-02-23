<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/crontab.php';
require 'contrib/npm.php';

require __DIR__ . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

function getEnv(string $key): string|null
{
    return $_ENV[$key] ?? $_SERVER[$key] ?? null;
}

// Config
set('repository', 'https://github.com/vermaysha/isp-admin.git');

add('writable_dirs', [
    'storage/debugbar',
    'storage/fonts',
]);

host('production')
    ->setHostname(getEnv('DEPLOYER_HOSTNAME'))
    ->setPort(getEnv('DEPLOYER_PORT'))
    ->setRemoteUser(getEnv('DEPLOYER_REMOTE_USER'))
    ->setDeployPath(getEnv('DEPLOYER_DEPLOY_PATH'));

// Task
desc('Build package');
task('npm:build', function () {
    run('cd {{release_path}} && {{bin/npm}} run prod');
});

// Hooks
after('deploy:success', 'crontab:sync');

add('crontab:jobs', [
    '* * * * * cd {{current_path}} && {{bin/php}} artisan schedule:run >> /dev/null 2>&1',
]);

after('deploy:failed', 'deploy:unlock');
after('deploy:update_code', 'npm:install');
after('npm:install', 'npm:build');
