<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'sm-semec');

// Project repository
set('repository', 'git@github.com:TaisHryssai/sm-semec.git');//git@github.com:utfpr-gp-tsi/sm-semec.git

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 
set('keep_releases', 3);
set('default_timeout', 600);

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', ['logs','public/uploads','vendor']);

// Hosts

host('production')
	->hostname('161.35.122.229')
	->user('deployer')
	->port(22)
	->identityFile('/var/www/.ssh/id_rsa')
	->stage('production')
    ->set('deploy_path', '/var/www/{{application}}')
    ->set('branch','production');    
    

/*
 * Tasks
 * --------------------------------- */

task('deploy:cp-docker-files', function () {
	upload('deploy/production/', "{{deploy_path}}");
    upload('deploy/php/', "{{deploy_path}}/shared/php/");
    upload('deploy/mysql/', "{{deploy_path}}/shared/mysql/");
})->onStage('production');

task('deploy:build-containers', function () {
    run('cd {{deploy_path}} && docker-compose stop app-semec');
    run('cd {{deploy_path}} && docker-compose build --build-arg USER_ID=$(id -u) --build-arg GROUP_ID=$(id -g) app-semec');
});

task('deploy:up-containers', function () {
    run('cd {{deploy_path}} && docker-compose up -d');
});

task('deploy:containers-ps', function () {
    run('cd {{deploy_path}} && docker-compose ps');
});

task('deploy:setup:docker', [
    'deploy:cp-docker-files',
    'deploy:build-containers',
    'deploy:up-containers',
    'deploy:containers-ps'
]);

/* --------------------------------- */

task('deploy:composer:install', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader');
});

task('deploy:artisan:key:generate', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan key:generate');
});

task('deploy:config:cache', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan config:cache');
});

task('deploy:migrate', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan migrate --force');
});

task('deploy:seed', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan db:seed --force');
});

task('deploy:assets', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec npm install');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec npm run production');
});

task('deploy:cache', function () {
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan route:cache');
    run('cd {{deploy_path}} && docker-compose exec -T -w {{release_path}} app-semec php artisan view:cache');
});

task('deploy:reload:php', function () {
    run('cd {{deploy_path}} && docker-compose exec -T app-semec kill -USR2 1');
});

task('deploy:reload:nginx', function () {
    run('sudo nginx -s reload');
});

/*
 * Task to deploy
 * --------------------------------- */
task('deploy', [
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:clear_paths',
    'deploy:composer:install',
    'deploy:config:cache',
    'deploy:migrate',
    'deploy:seed',
    'deploy:assets',
    'deploy:cache',
    'deploy:reload:php',
    'deploy:reload:nginx',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

after('deploy:failed', 'deploy:unlock');
