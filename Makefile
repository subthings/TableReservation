update:
	docker-compose down
	git pull
	docker-compose build
	docker-compose up -d
	docker-compose exec --user=www-data php composer install
	docker-compose exec --user=www-data php bin/console doctrine:schema:update -f
	docker-compose exec --user=www-data php bin/console cache:clear
