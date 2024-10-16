composer install

if [ ! -f ".env" ]; then
  cp .env.example .env
  php artisan key:generate
fi

php-fpm