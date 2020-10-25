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

echo 'Updating symlinks...'
sudo ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};

sudo ln -s {{$global_uploads_dir}} {{$app_uploads_dir}}

echo 'Deployment to {{$target}} finished successfully.'
@endtask
