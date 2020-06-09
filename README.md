# Team Project

### Technology Stack:
**Backend:** Laravel 7.x   
**Frontend:** Vue.js  
**Database:** MySQL
 
 
### How To Install:
1. Download or clone repository  
    ```
    git clone https://github.com/PatrykJelonek/teamproject
    ```
2. Install Composer dependencies  
    ``` 
    composer install
    ```
3. Install NPM dependencies
    ```
    npm install
    ```
4. Enter into project directory 
    ```
    cd teamproject
    ```
5. Create a copy of `.env` files
6. Generate an app encryption key
    ```
    php artisan key:generate
    ```
7. Generate a JWT Secret Token
    ```
   php artisan jwt:secret
   ```
8. Create an empty database
9. Change `.env` files by data to connect with database
10. Migrate the database
    ```
    php artisan migrate
    ```
11. Seed the database
    ```
    php artisan db:seed
    ```
