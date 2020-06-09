TODO:
```bash
    sudo nano /etc/hosts
    127.0.0.1 slotegrator.loc
```

```bash
    git clone $REPO_URI
    cp .env.example .env
    chmod 777 ./do.sh
    make start
    composer install
    docker exec -it slotegrator-php ash
    php artisan key:generate 
    php artisan migrate
    php artisan db:seed
    php artisan serve
    php artisan cache:clear
    php artisan config:clear
    docker exec -it slotegrator-php ash
    ./vendor/bin/phpunit tests/Unit/ConvertMoneyToBonusAndSaveMethodTest.php
    
    php artisan money:transfer --limit=5 
```
task
```
Нужно разработать веб-приложение для розыгрыша призов. После аутентификации пользователь
может нажать на кнопку и получить случайный приз. Призы бывают 3х типов: денежный (случайная
сумма в интервале), бонусные баллы (случайная сумма в интервале), физический предмет (случайный
предмет из списка).
Денежный приз может быть перечислен на счет пользователя в банке (HTTP запрос к API банка),
баллы зачислены на счет лояльности в приложении, предмет отправлен по почте (вручную
работником). Денежный приз может конвертироваться в баллы лояльности с учетом коэффициента.
От приза можно отказаться. Деньги и предметы ограничены, баллы лояльности нет.


-Реализация с помощью фреймворка (можно любой, но лучше Yii или Yii2), использованием БД.
-Нужно добавить консольную команду которая будет отправлять денежные призы на счета
пользователей, которые еще не были отправлены пачками по N штук.
-Добавить юнит-тест конвертирования денежного приза в баллы лояльности
```
