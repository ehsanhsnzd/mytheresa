deploy:
	docker-compose build
	docker-compose up -d
	docker-compose exec app cp .env.example .env
	docker-compose exec app composer install
	docker-compose exec app /var/www/html/artisan key:generate
	docker-compose exec app /var/www/html/artisan migrate --force
	docker-compose exec app /var/www/html/artisan config:cache
	docker-compose exec app /var/www/html/artisan route:cache
	docker-compose exec app ./vendor/bin/phpunit --repeat 10
	docker-compose exec app /var/www/html/artisan db:seed
	@echo "\033[0;32mDeployed.\033[0m"
	@echo "http://localhost:8000/products?category=boots&priceLessThan=1000000"

test:
	docker-compose exec app ./vendor/bin/phpunit --repeat 10

logs:
	tail -f storage/logs/laravel.log

cleanup:
	cat /dev/null > storage/logs/laravel.log
