## Тестовое задание на позицию PHP бэкенд разработчика (от 2 мая 2022)
### Для компании abz.agency

Задание доступно по [ссылке](https://drive.google.com/file/d/1zUC2D72mGqSip5-3zvKJYGMsd7-KEfHG/view)
1. Проект представляет собой REST API сервер, спроэктированный согласно данной [API документацией](https://www.google.com/url?q=https://apidocs.abz.dev/test_assignment_for_frontend_developer_api_documentation&sa=D&source=apps-viewer-frontend&ust=1653745913936392&usg=AOvVaw12hStHMBD3_Bh0VTuwOFsd&hl=ru);
2. Имеется Seeder для первоначального заполнения БД 45 юзерами;
3. В проэкте использован API сервис сервис для оптимизации изображений [tinypng.com](https://tinypng.com/), пакет выдачи JWT токена [jwt-auth](https://github.com/tymondesigns/jwt-auth);
4. Фронтенд часть расположена в другом [репозитории](https://github.com/merabuk/abz.rest.api);


## Установка

1. Клонировать репозиторий (SSH): `git clone git@github.com:merabuk/abz.rest.api.server.git`
2. Перейти в папку с проэктом: `cd abz.rest.api.server`
3. Установить зависимости composer: `composer install`
4. Создать файл .env в корне приложения: `cp .env.example .env`
5. Настроить .env файл (URL, база данных) + создать БД и пользователя БД, поля `ADMIN_EMAIL`, `ADMIN_PASSWORD`, [`TINIFY_APIKEY`](https://tinypng.com/developers)
6. Сгенерировать ключ приложения: `php artisan key:generate`
7. Сгенерировать секретный ключ JWT: `php artisan jwt:secret`
8. Запустить миграции БД: `php artisan migrate:fresh --seed`
9. Почистить кеш: `php artisan optimize:clear`


## Test task for the position of PHP backend developer (dated May 2, 2022)
### For abz.agency
The task is available at [link](https://drive.google.com/file/d/1zUC2D72mGqSip5-3zvKJYGMsd7-KEfHG/view)
1. The project is a REST API server designed according to this [API documentation](https://www.google.com/url?q=https://apidocs.abz.dev/test_assignment_for_frontend_developer_api_documentation&sa=D&source=apps-viewer-frontend&ust=1653745913936392&usg=AOvVaw12hStHMBD3_Bh0VTuwOFsd&hl=ru);
2. There is a Seeder for the initial filling of the database with 45 users;
3. The project used API service for image optimization [tinypng.com](https://tinypng.com/), JWT token issue package [jwt-auth](https://github.com/tymondesigns/jwt-auth );
4. The frontend part is located in another [repository](https://github.com/merabuk/abz.rest.api);

## Installation

1. Clone repository (SSH): `git clone git@github.com:merabuk/abz.rest.api.server.git`
2. Go to the project folder: `cd abz.rest.api.server`
3. Install composer dependencies: `composer install`
4. Create an .env file at the root of the application: `cp .env.example .env`
5. Set up .env file (URL, database) + create DB and DB user, fields `ADMIN_EMAIL`, `ADMIN_PASSWORD`, [`TINIFY_APIKEY`](https://tinypng.com/developers)
6. Generate application key: `php artisan key:generate`
7. Generate JWT secret key: `php artisan jwt:secret`
8. Run database migrations: `php artisan migrate:fresh --seed`
9. Clear cache: `php artisan optimize:clear`
