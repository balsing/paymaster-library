# Библиотека для взаимодействия с сервисом [ESCROW](https://guarantee.money)

## Что предоставляет:
Библиотека предоставляет возмодность делать запросы к сервису через API методы.

**Важно:**  Библиотека не берёт на себя функционал по валидации данных и параметров, которые передаются в сервис. Для создания правильных запросов, необходимо пользоваться [оффициальной документацией](https://guarantee.money/developers).

## Требования

* PHP >= 7.1
* [HttpClient component](https://github.com/symfony/http-client),

## Установка
1. Добавить в секцию ``repositories``:
```
{
    "type": "git",
    "url": "https://git.crtweb.ru/youtool/paymaster-library.git"
}
```

2. Выполнить команду 

```
composer require youtool/paymaster-library
```

## Пример использования:
```
// Подключаем Autoloader с зависимостями
include __DIR__.'/vendor/autoload.php'; 
...
use Paymaster\Paymaster;
use Paymaster\Response;

$paymaster = new Paymaster();

/** @var Response $response */
$response = $paymaster->getProfile()->get();
if($response->isSuccess()){
    var_dump($response->getData());
}
```
При необходимости нужно указать токен для авторизации:
```
$token = 'your_token';
$paymaster->setBearerToken($token);
```

## License

MIT License
