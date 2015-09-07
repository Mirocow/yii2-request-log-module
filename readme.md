# Yii2 request log module

[Yii2](http://www.yiiframework.com) request log module.

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
php composer.phar require mirocow/yii2-request-log-module "dev-master"
```

or add

```
"mirocow/yii2-request-log-module": "dev-master"
```

to the require section of your ```composer.json```

## Usage

Configure Request log module in config:

```php
'modules' => [
    'request-log' => [
        'class' => mirocow\requestlog\RequestLog\Module::className(),
        // username attribute in your identity class (User)
        'usernameAttribute' => 'name'
    ]
]
```

Run:

```
php yii migrate --migrationPath=@mirocow/requestlog/RequestLog/migrations
```

### Exclude rules

Write in bootstrap.php for excluding of some logs:

```php
Yii::$container->set(\mirocow\requestlog\RequestLog\behaviors\RequestLogBehavior::className(), [
    'excludeRules' => [
        function () {
            list ($route, $params) = Yii::$app->getRequest()->resolve();
            return $route === 'debug/default/toolbar';
        }
    ]
]);

```

## Author

[Aleksandr Zelenin](https://github.com/zelenin/), e-mail: [aleksandr@zelenin.me](mailto:aleksandr@zelenin.me)
