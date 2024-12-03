## First initialize project

1. Run the following command to clone the project
   `git clone https://github.com/rsakml/Penilaian-Esai.git`

2. Run the following command to update the laravel package.
   `composer update`

3. Run the following command to copy the env.example file into .env
   `cp .env.example .env`

4. Run the following command to generate key
   `php artisan key:generate`

5. Import database ke MySQL database. Sesuaikan nama database pada MySQL dengan yang ada pada project Laravel, file .env. 

6. Then run laravel on another port, this case using port = 8001  
   `Penilaian-Esai>php artisan serve –-port=8001` 