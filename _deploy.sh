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
composer install
composer dump-autoload
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
cp -r * ~/long-stay-bali.diw.co.id
cp .htaccess ~/long-stay-bali.diw.co.id/
cd ~/long-stay-bali.diw.co.id/
rm -f index.php
cp -f server.php index.php
cd ~/src
echo ""

echo "UP"
php artisan up
echo ""

echo "END DEPLOY"
