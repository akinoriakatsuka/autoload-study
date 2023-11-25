## 環境構築

### sail

```bash
curl -s "https://laravel.build/autoload-study?with=pgsql" | bash
```

## laravelのautoload

### autoloaderの読み込み

`public/index.php` で `/vendor/autoload.php` を読み込んでいる。

```php
require __DIR__.'/../vendor/autoload.php';
``` 

`/vendor/autoload.php` は `/vendor/composer/autoload_real.php` を読み込んでいる。

```php
require_once __DIR__ . '/composer/autoload_real.php';
```

`/vendor/autoload.php` は `ComposerAutoloaderInit8757dc4dc53ffcc00810a058449bb35e` クラスの `getLoader` メソッドの戻り値を返している。

```php
return ComposerAutoloaderInit8757dc4dc53ffcc00810a058449bb35e::getLoader();
```

### `/composer/autoload_real.php`ファイルの中身

`ComposerAutoloaderInit8757dc4dc53ffcc00810a058449bb35e` クラス

1つのプロパティと2つのメソッド
- `private static $loader`
- `public static function loadClassLoader($class)`
- `public static function getLoader()`

#### $loaderプロパティ
\Composer\Autoload\ClassLoader クラスのインスタンスが入る



## sample-appのautoload

スクラッチ想定のアプリケーション

### composerをインストール

composer.jsonを作成
```json
{
    "autoload": {
    }
}
```

```bash
composer install
```

.gitignoreに `vendor/` を追加

### autoloadを追加してみる

`composer.json` に以下を追加

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    }
}
```




