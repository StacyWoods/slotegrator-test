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
    //php artisan admin:install
    php artisan db:seed
    //php artisan db:seed --class=AdminMenuTableSeeder
    //php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
```
