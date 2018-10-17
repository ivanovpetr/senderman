# Senderman
![Иллюстрация](./illustration.jpg)

Прототип микросервиса рассылки сообщений по мессенджерам.

Цель создания - тренировка навыка конструирования микросервисов.

## Архитектура

Сервис построен на связке Docker контейнеров
- Приложение
- Redis для хранения очереди сообщений
- PHP демон очереди
- MySQL для сохранения сообщений которые не удалось отправить
- Nginx для обработки запросов

Приложение базируется на связке Lumen + Dingo/Api.
Lumen отлично походит для данной задумки.
Встроенная очередь, валидация и быстрый роутер это как раз то что нужно.
Dingo/Api предоставляет полезных ряд инструментов для создания апи.

### Авторизация
Аутентификация и Авторизация максимально упрощены и построены на основе JWT.
Вдохновение черпалось [отсюда](https://www.youtube.com/watch?v=SLc3cTlypwM)

## Работа с сервисом

### Команды

Комманда                                      | Описание
--------------------------------------------- | -----------
`docker-compose up -d`                        | Запуск контейнеров 
`docker-compose exec php php artisan`         | Взаимодействие с Artisan
`docker-compose exec php composer`            | Взаимодействие с Composer
`docker-compose exec php ./vendor/bin/phpunit`| Запуск тестов
`docker-compose down`                         | Остановка и удаление контейнеров

### Инструкция по установке

Клонировать репозиторий
```bash
    $ git clone repository 
    $ cd senderman
```
Запуск контейнеров
```bash
    $ docker-compose up -d
```
Установка зависимостей 
```bash
    $ docker-compose exec php composer install
```
Создать .env файл
```bash
    $ docker-compose exec php cp .env.example .env
```
Создаем таблицу для неотправленных сообщений
```bash
    $ docker-compose exec php php artisan queue:failed-table
    $ docker-compose exec php php artisan migrate
```

### Работа с API
Для авторизации необходим токен. Его можно получить по корневому пути `/` (Это временное решение).
Остальные методы доступны по префиксу `/api`.

```bash
$ curl GET scheme://senderman/
```
**sendMessages**`POST` 
> Поля
 - `message` - Текст сообщения.
 - `receivers[]` - Массив телефонных номеров получателей.
 - `messengers[]` - Массив мессенджеров.
 - `time(optional)` - Время в формате "DD-MM-YYYY hh:mm".
 - `timezone` - Временная зона. Полный список [тут](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones).
> Заголовки
- `Authorization: Bearer <JWT>`
- `Accept: application/vnd.senderman.v1+json`
```bash
$ curl POST scheme://senderman/api/sendMessages \
    -H "Authorization: Bearer <JWT>" \
    -H "Accept: application/vnd.senderman.v1+json" \
    -d '{
      "message": "Happy new year!",
      "receivers": [
        "+79951231212",
        "+79991231212"
      ],
      "messengers": [
        "telegram"
        "viber"
      ],
      "time": "01-01-2018 00:05",
      "timezone": "Europe/Moscow"
    }'
```