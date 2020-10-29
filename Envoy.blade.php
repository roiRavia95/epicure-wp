@include('vendor/autoload.php');
@setup

if(!isset($target)){
$target = 'dev';
echo("\n\n        WARNING: No target deployment environment specified - deploying to staging by default.\n\n\n");
};

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$repo = 'git@github.com:roiRavia95/epicure-wp.git';

$theme_dir = 'web/app/themes/Epicure';
$app_dir = '/var/www/html';
$release_dir = '/home/ubuntu/releases';

$deploy_date = date('YmdHis');
$release = 'release_' . $deploy_date;

$global_uploads_dir = '/home/ubuntu/uploads';
$app_uploads_dir = $app_dir . '/web/app/uploads';

$web_app_dir = 'web/app';

$servers = [
    'local'=>'127.0.0.1',
    'dev' => 'ubuntu@3.137.151.188',
    'prod'=>''
];

if(!isset($branch)){
$branch = 'develop';
};

@endsetup

@servers($servers)

@story('deploy')
upload_compiled_assets
fetch_repo
run_install
run_after_install
@endstory

@task('upload_compiled_assets',['on'=>'local'])
cd {{$theme_dir}}
npm run production
tar -czf assets-{{$release}}.tar.gz dist
scp assets-{{$release}}.tar.gz  {{$servers[$target]}}:~
rm -rf assets-{{$release}}.tar.gz
@endtask

@task('fetch_repo',['on'=>$target])
[ -d {{$release_dir}} ] || sudo mkdir {{$release_dir}};
cd {{$release_dir}};
sudo chown ubuntu {{ $release_dir }};
sudo chgrp ubuntu {{ $release_dir }};
git clone --single-branch -b  {{$branch}} {{$repo}} {{$release}};
@endtask

@task('run_install',['on'=>$target])
cd {{ $release_dir }}/{{ $release }};
cp ~/.env .
composer install --no-dev --prefer-dist
echo 'composer installed.'
composer update --ignore-platform-reqs
echo 'composer updated.'
@endtask

@task('run_after_install',['on'=>$target])
echo 'Installing compiled assets...'
cd ~
tar -xzf assets-{{ $release }}.tar.gz -C {{ $release_dir }}/{{ $release }}/{{ $theme_dir }}
rm -rf assets-{{ $release }}.tar.gz

cd {{ $release_dir }}

echo 'Setting permissions...'

sudo chgrp -R www-data {{ $release }};
sudo chmod -R ug+rwx {{ $release }};
sudo chown -R www-data {{ $release }};

echo 'Updating symlinks...'
sudo ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};
sudo rm -r {{$app_uploads_dir}}
sudo ln -s {{$global_uploads_dir}} {{$app_uploads_dir}}

sudo rm -r {{$app_dir}}/{{$web_app_dir}}/plugins
sudo ln -nfs ~/plugins {{$app_dir}}/{{$web_app_dir}}/plugins ;

echo 'Deployment to {{$target}} finished successfully.'
@endtask

@story('setup_plugins')
export_plugins
extract_plugins
@endstory

@task('export_plugins',['on'=>'local'])
cd {{ $web_app_dir }};

tar -czf plugins.tar.gz plugins
scp plugins.tar.gz  {{$servers[$target]}}:~
rm -rf plugins.tar.gz

echo 'Done setting up plugins'
@endtask

@task('extract_plugins',['on'=>$target])
cd ~

sudo tar -xzf plugins.tar.gz -C {{$app_dir}}/web/app/plugins
rm -rf plugins.tar.gz

echo 'finished extracting plugins'
@endtask


@story('setup_uploads')
export_uploads
extract_uploads
@endstory

@task('export_uploads',['on'=>'local'])
cd {{ $web_app_dir }};

tar -czf uploads.tar.gz uploads
scp uploads.tar.gz  {{$servers[$target]}}:~
rm -rf uploads.tar.gz

echo 'Done setting up uploads'
@endtask

@task('extract_uploads',['on'=>$target])
cd ~
sudo tar -xzf uploads.tar.gz -C uploads
rm -rf uploads.tar.gz

echo 'finished extracting uploads'
@endtask

