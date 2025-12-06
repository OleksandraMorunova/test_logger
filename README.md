Реалізувати спрощений модуль логування на Yii2.
Пропонується реалізувати наступний інтерфейс, з яким і будуть працювати клієнти даного модуля:
Interface LoggerInterface
```
{
/**
* Sends message to current logger.
*
* @param string $message
* @return void
*/
public function send(string $message): void;

/**
* Sends message by selected logger.
*
* @param string $message
* @param string $loggerType
* 
* @retun void
*/
public function sendByLogger(string $message, string $loggerType): void;

/**
* Gets current logger type
*
* @return string
*/
public function getType(): string;

/**
* Sets current logger type
* 
* @param string $type
*/
public function setType(string $type); void;
}
```
Логер повинен вміти працювати з різними типами логування: 
- відправка повідомлення на емейл (емейл задається в конфігураційному файлі);
- запис в базу даних;
- запис в файл.
  
Тип логування по замовчуванню задається в конфігураційному файлі, проте може бути змінений динамічно.
Важливо врахувати, що з часом кількість типів логування може зростати, але це не повинно зачіпати існуючий функціонал.
Для створення об’єкта (ів) логування реалізувати фабрику (и). Крім того в завданні необхідно використовувати namespace.

Реалізовувати графічний інтерфейс немає потреби. Також допускається просте виведення на екран тексту в якості реалізації відправки емейлу, запису у файл або в БД:
"4f5dbc 65897a9 0828 29ca68 7da995b cd4fc3 7a658." was sent via email
"a86029c 5768425 a15560 8562ed e841a1 0aed b4dd27d 9af35 10cdecf4 8af333ec." was sent via file
"ebcba08 28f360 93adcc6 3c32 2bb 5b89b56 4ba7b3 c6334 6459d5 ca5b." was sent via db
Готове завдання повинне включати в себе:
- контролер з наступними методами:
```
/**
* Sends a log message to the default logger.
*/
public function log()
{

}

/**
* Sends a log message to a special logger.
*
* @param string $type
*/
public function logTo(string $type)
{

}

/**
* Sends a log message to all loggers.
*/
public function logToAll()
{

}
```
- конфігураційний файл з масивом налаштувань (емейл, поточний тип логера);
- набір моделей необхідних для реалізації логування.

Виконане завдання завантажити на GitHub/GitLab/Bitbucket (на свій вибір).
