RUN docker-compose exec app php artisan key:generate
RUN docker-compose exec app php artisan config:cache

RUN docker-compose up -d
# docker-compose exec mysql bash
# mysql -u root -p
# root
# show databases;
# GRANT ALL ON laravel.* TO 'root'@'%' IDENTIFIED BY 'root';
# FLUSH PRIVILEGES;
# EXIT;

#rm bootstrap/cache/config.php
#php artisan cache:clear
#composer dump-autoload

RUN php artisan migrate
RUN php artisan db:seed
