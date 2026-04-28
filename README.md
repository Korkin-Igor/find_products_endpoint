# Product Catalog API

Тестовое задание: реализация API для каталога товаров с фильтрацией и сортировкой.

## Стек
- PHP 8.2
- Laravel 11
- PostgreSQL

## Функционал
- Поиск по названию (`q`)
- Фильтрация по цене (`price_from`, `price_to`)
- Фильтрация по категориям (массив `category_id`)
- Фильтрация по наличию (`in_stock`)
- Сортировка (`sort[]`): price_asc, price_desc, newest, rating_desc

## Установка и запуск

1. Клонирование проекта:
```bash
git clone <https://github.com/korkin-igor/find_products_endpoint.git>
cd find_products_endpoint
```

2. Установка зависимостей:
```bash
composer install
```

3. Настройка окружения:
```bash
cp .env.example .env
touch .env
php artisan key:generate
```

4. Миграции и наполнение базы:
```bash
php artisan migrate --seed
```

5. Запуск:
```bash
php artisan serve
```

## Пример запроса
`GET /api/products?q=phone&price_from=100&category_id[]=1&category_id[]=2&sort[]=price_asc`
