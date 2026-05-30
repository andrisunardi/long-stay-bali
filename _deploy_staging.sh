echo "START DEPLOY"
echo ""

echo "DOWN"
php artisan down --render="errors.maintenance" --secret="dev"
echo ""

echo "CLEAN GIT"
git clean -df
git checkout .
git fetch --all --prune
git reset --hard
echo ""

echo "BRANCH MAIN"
git checkout main
git pull origin main
echo ""

echo "COMPOSER"
php composer.phar install --ignore-platform-reqs
php composer.phar dump-autoload
echo ""

echo "MIGRATION"
php artisan migrate --force
echo ""

echo "OPTIMIZE"
php artisan clear-compiled
php artisan optimize
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
php artisan optimize:clear
echo ""

echo "PUBLIC HTML"
cd public
cp -r * ~/staging.solivingbali.com
cp .htaccess ~/staging.solivingbali.com/
cd ~/staging.solivingbali.com/
rm -f index.php
cp -f server_staging.php index.php
cd ~/src-staging
echo ""

echo "UP"
php artisan up
echo ""

echo "END DEPLOY"
