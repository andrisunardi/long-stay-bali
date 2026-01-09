echo "START DEPLOY"
echo ""

echo "DOWN"
/usr/bin/php8.3 artisan down --render="errors.maintenance" --secret="dev"
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
/usr/bin/php8.3 /usr/local/bin/composer install
/usr/bin/php8.3 /usr/local/bin/composer dump-autoload
echo ""

echo "MIGRATION"
/usr/bin/php8.3 artisan migrate --force
echo ""

echo "OPTIMIZE"
/usr/bin/php8.3 artisan clear-compiled
/usr/bin/php8.3 artisan optimize
/usr/bin/php8.3 artisan config:cache
/usr/bin/php8.3 artisan event:cache
/usr/bin/php8.3 artisan route:cache
/usr/bin/php8.3 artisan view:cache
/usr/bin/php8.3 artisan optimize:clear
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
/usr/bin/php8.3 artisan up
echo ""

echo "END DEPLOY"
