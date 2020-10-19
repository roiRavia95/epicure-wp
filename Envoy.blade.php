@setup
{{--If no server has been selected in the task, run in dev environment--}}
if(!isset($target)){
$target = 'dev';
echo("\n\n        WARNING: No target deployment environment specified - deploying to staging by default.\n\n\n");
};

{{--Define git repository--}}
$repo = 'git@github.com:roiRavia95/epicure-wp.git'

{{--Define relevant directories--}}
$theme_dir = 'web/app/themes/Epicure'
$app_dir = 'var/www/html'
$release_dir = 'home/ubuntu/releases'
$global_uploads_dir = 'home/ubuntu/uploads'
$app_uploads_dir = $app_dir . '/web/app/uploads';
{{--Relevant data for release--}}
$deploy_date = date('YmdHis');
$release = 'release_' . $deploy_date;


{{--Define Servers--}}
$servers = [
    'local'=>'127.0.0.1',
    'dev' => 'ubuntu@3.16.23.244',
    'prod'=>''
];

{{--Safe check for $branch--}}
if(!isset($branch)){
$branch = 'develop';
};

@endsetup

{{--Initiate the servers - allowing me to use the "on" option in a task--}}
@servers($servers)

{{--Create the 'deploy' story to run a number of tasks in a sequence--}}
@story('deploy')
upload_compiled_assets
fetch_repo
run_install
run_after_install
@endstory

{{--Securely upload compiled assets from local machine to remote host--}}

@task('upload_compiled_assets',['on'=>'local'])
{{--go to theme directory--}}
cd {{$theme_dir}}
{{--run npm production--}}
npm run production
{{--use "tar -czf" to compress the directory to a single file on Linux--}}
tar -czf assets-{{$release}}.tar.gz dist
{{--Use "scp" to securely copy the compressed file to the remote server and then remove it--}}
scp assets-{{$release}}.tar.gz  {{$servers[$target]}}:~
{{--copy the version hash--}}
scp ./build/version-hash.txt  {{$servers[$target]}}:~
{{--Remove the compressed file--}}
rm -rf assets-{{$release}}.tar.gz

{{--use "wp plugin list" command to export plugins status in json format--}}
wp plugin list --format=json > ./plugins-export.json
{{--copy to remote target server--}}
scp ./plugins-export.json {{$servers[$target]}}:~

{{--Remove locally generated list--}}
rm ./plugins-export.json
@endtask

{{--Fetch code from repo and clone it to release directory--}}

@task('fetch_repo',['on'=>$target])
[ -d{{$release_dir}} ] || sudo mkdir {{$release_dir}};
cd {{$release_dir}};
git clone --single-branch -b {{$branch}} {{$repo}} {{$release}};
@endtask

{{--Copy .env to release directory and Update all dependencies--}}

@task('run_install',['on'=>$target])
cd {{ $release_dir }}/{{ $release }};
cp ~/.env .
git pull origin master --force
composer install --no-dev --prefer-dist
@endtask

@task('run_after_install',['on'=>$target])
echo 'Installing compiled assets...'
cd ~
{{--Extract release and copy it the relevant directory--}}
tar -xzf assets-{{ $release }}.tar.gz -C {{ $release_dir }}/{{ $release }}/{{ $theme_dir }}
{{--Remove it from the home directory--}}
rm -rf assets-{{ $release }}.tar.gz

{{--Move the version-hash --}}
mv version-hash.txt {{ $release_dir }}/{{ $release }}/{{ $theme_dir }}/build/

cd {{ $release_dir }}

echo 'Setting permissions...'

{{--Change the group ownership to that of the web server--}}
sudo chgrp -R www-data {{ $release }};
{{--Set permissions users in this group to read,write and execute--}}
sudo chmod -R ug+rwx {{ $release }};

{{--Link between release folder to app directory with symbolic links--}}
echo 'Updating symlinks...'
sudo ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};
{{--Link between the global uploads dir to the app uploads dir (update uploads directory)--}}
sudo rm -r {{ $app_uploads_dir }}
sudo ln -s {{$global_uploads_dir}} {{$app_uploads_dir}}

echo 'Deployment to {{$target}} finished successfully.'
@endtask
