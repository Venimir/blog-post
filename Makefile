build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
		docker exec blog-post bash -c "composer update"
data:
	docker exec blog-post bash -c "php artisan migrate"
	docker exec blog-post bash -c "php artisan db:seed"