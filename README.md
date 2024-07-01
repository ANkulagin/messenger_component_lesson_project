# Пример реализации отправки Уведомлений об Автоматической Публикации Статей на примере Symfony component messenger
Описание
Уведомления отправляются асинхронно через Loop/Slack(Bender), чтобы не блокировать основной поток выполнения.


Запуск основной очереди сообщений:
```sh
php bin/console messenger:consume doctrine -vv
```
Повторная обработка неудачных сообщений:
```sh
php bin/console messenger:failed:retry
```
Повторная обработка неудачных сообщений: без выбора определённого действия
```sh
php bin/console messenger:failed:retry --force
```
