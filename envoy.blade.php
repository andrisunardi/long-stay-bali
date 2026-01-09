@setup
    require __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
@endsetup

@servers(['web' => env("DEPLOY_SERVER")])

@task('deploy', ['on' => ['web']])
    echo Start Deploy

    echo DEPLOY SERVER : {{ env('DEPLOY_SERVER') }}
    echo DEPLOY DIRECTORY : {{ env('DEPLOY_DIRECTORY') }}
    echo DEPLOY BRANCH : {{ env('DEPLOY_BRANCH') }}
    echo DEPLOY RENDER : {{ env('DEPLOY_RENDER') }}
    echo DEPLOY SECRET : {{ env('DEPLOY_SECRET') }}

    echo cd directory {{ $directory ?? env("DEPLOY_DIRECTORY") }}
    cd {{ $directory ?? env("DEPLOY_DIRECTORY") }}

    echo php artisan down --render={{ $render ?? env("DEPLOY_RENDER") }} --secret={{ $secret ?? env("DEPLOY_SECRET") }}
    php artisan down --render={{ $render ?? env("DEPLOY_RENDER") }} --secret={{ $secret ?? env("DEPLOY_SECRET") }}

    echo Git Pull Origin {{ $branch ?? env("DEPLOY_BRANCH") }}
    git pull origin {{ $branch ?? env("DEPLOY_BRANCH") }}

    echo Composer Install
    composer install

    echo php artisan migrate --force
    php artisan migrate --force

    echo php artisan optimize:clear
    php artisan optimize:clear

    echo php artisan up
    php artisan up

    echo End Deploy
@endtask
