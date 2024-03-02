## How to start

```bash
composer install
cp .env.example .env
touch database/database.sqlite
npm install
./vendor/bin/sail up
npm run dev
php artisan migrate
php artisan db:seed
```

and then visit `localhost` in your browser.