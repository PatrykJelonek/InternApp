# InternApp 👨🏼‍🎓 

### Technology Stack:
**Backend:** Laravel 7.x   
**Frontend:** Vue.js 2  
**Database:** MySQL
 
 
### How To Install:
1. Download or clone repository  
    ```
    git clone https://github.com/PatrykJelonek/teamproject
    ```
2. Enter into project directory 
    ```
    cd teamproject
    ```
3. Create directories
   ``` 
   mkdir -p storage/framework/{cache,sessions,views} 
   ```
4. Create a copy of `.env` files
    ```
    cp .env.example .env
    ```
5. Install Composer dependencies  
    ``` 
    composer update
    composer install
    ```
6. Install NPM dependencies
    ```
    npm install
    ```
7. Generate an app encryption key
    ```
    php artisan key:generate
    ```
8. Generate a JWT Secret Token
    ```
   php artisan jwt:secret
   ```
9. Create an empty database
10. Change `.env` files by data to connect with database
11. Migrate the database
    ```
    php artisan migrate
    ```
12. Seed the database
    ```
    php artisan db:seed
    ```
13. Run a server & queues
    ```
    php artisan serve
    php artisan queue:work
    ```
