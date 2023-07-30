# Конфигуратор дверей


## Установка и запуск проекта

Для запуска проекта потребуются:
- Open Server
- Composer

Порядок установки проекта:
- склонировать проект;
- в папке /external распаковать архив tcpdf (библиотека для генерации pdf-файла), путь до скрипта должен быть следующим: /external/tcpdf/tcpdf.php
- в папке /migrations импортировать тестовую базу test_bd.sql


Устанавливаем зависимости
```bash
composer install
```

Запуск проекта локально
```bash
symfony server:start -d
```

Остановка проекта
```bash
symfony server:stop
```

Сброс кэша
```bash
 php bin/console cache:pool:clear cache.global_clearer
```

Для локальной работы с базой данных необходим скорректировать строку подключения к бд в файле .env (лежит в корне проекта), пример:
```bash
DATABASE_URL="mysql://root@doorconfig:3306/doors?serverVersion=8&charset=utf8mb4"
```

Структура проекта:

- /external - для библиотек
- /files/pdf - хранение сгенерированных pdf-файлов

Для модулей/сервисов описание в аннотации перед объявлением класса

Для отправки pdf-файлов в телеграм необходимо прописать идентификатор чата и личный токен в сервисе:

```bash
/src/Service/TelegramService.php
```