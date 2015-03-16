# Yii2 request log module

[Yii2](http://www.yiiframework.com) request log module.

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
php composer.phar require zelenin/yii2-request-log-module "dev-master"
```

or add

```
"zelenin/yii2-request-log-module": "dev-master"
```

to the require section of your ```composer.json```

## Usage

Configure Request log module in config:

```php
'modules' => [
    'request-log' => [
        'class' => Zelenin\yii\modules\RequestLog\Module::className(),
        // username attribute in your identity class (User)
        'usernameAttribute' => 'name'
    ]
]
```

Run:

```
php yii migrate --migrationPath=@Zelenin/yii/modules/RequestLog/migrations
```

### Exclude rules

Write in bootstrap.php for excluding of some logs:

```php
Yii::$container->set(\Zelenin\yii\modules\RequestLog\behaviors\RequestLogBehavior::className(), [
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
