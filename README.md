<p align="center">
    <h1 align="center">Develit test case</h1>
    <br>
</p>

Приложение разделено на две части (backend и frontend), так как у системы есть два типа пользователей - менеджеры магазина и покупатели. У них разное поведение, разные бизнес задачи, которые пересекаются только на уровне данных. Данные для взаимодействия между частями приложения и общий функционал находятся в папке common и могут наследоваться
в backend и frontend для реализации специфичной приложению логики в будущем.

-------------------

```
common
    models/              Общие модели для crm и api
    integrations/        Api и адаптер на случай если их будет несколько

console
    controllers/         сиды
    migrations/          миграции

backend                  CRM для управления продуктами

frontend
    v1/                  rest api
```

# Запуск стека приложений

    docker-compose up -d

# Миграции

    docker-compose run --rm backend yii migrate  

# Сиды

    docker-compose run --rm backend yii seed/user  

# CRM
<http://localhost:21080>

логин: admin

пароль: admin

# API

## Список продуктов

    GET http://localhost:20080/v1/products?expand=productCard,productImage

## Payson iframe

    GET http://localhost:20080/v1/payment
