cd /home/forge/mailtool.biz
git pull origin
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan queue:restart

npm install
npm run prod
