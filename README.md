# Библиотека для взаимодействия с сервисом [ESCROW](https://guarantee.money)

## Что предоставляет:
Библиотека предоставляет возмодность делать запросы к сервису через API методы.

**Важно:**  Библиотека не берёт на себя функционал по валидации данных и параметров, которые передаются в сервис. Для создания правильных запросов, необходимо пользоваться [оффициальной документацией](https://guarantee.money/developers).

## Пример использования:
```
// Подключаем Autoloader с зависимостями
include __DIR__.'/vendor/autoload.php'; 
...
use Paymaster\Paymaster;
use Paymaster\Transport;
use Paymaster\Response;

$paymaster = new Paymaster((new Transport()));

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
