# default-db
Данный репозиторий нужен, чтобы не писать класс для работы с БД каждый раз

1. Для начала работы с классом необходио подключиться к БД. getInstance - создаёт экземлпяр класса и устанавливает соединение с БД.
```php
$db = DB::getInstance();
```

2. Выполнение запросов
```php
$query = $db->query("SELECT * FROM `users`");
```

3. Выполнение запросов с данными
```php
$params = [
  'name' => 'NAME',
  'email' => 'example@domain.com'
];

$db->queryWithPrepare("INSERT INTO `users` (`name`, `email`) VALUES (:name, :email)", $params);
```

ИЛИ

```php
$params = ['NAME', 'example@domain.com'];

$db->queryWithPrepare("INSERT INTO `users` (`name`, `email`) VALUES (?, ?)", $params);
```

4. Получить одну строчку из БД
```php
$params = [
  'id' => 1
];

$query = $db->queryWithPrepare("SELECT * FROM `users` WHERE `id` = :id", $params)->fetch();
```

5. Получить все данные из БД
```php
$params = [
  'id' => 1
];

$query = $db->queryWithPrepare("SELECT * FROM `users` WHERE `id` = :id", $params)->fetchAll();
```
