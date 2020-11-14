cp .env.example .env
composer install
php artisan key:generate
php artisan jwt:secret
php artisan config:cache
php artisan migrate:refresh

npm install
bash install.sh
npm install --global cross-env
npm run production
