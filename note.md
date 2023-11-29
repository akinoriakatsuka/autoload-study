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

### loadClass の実装

ClassLoader クラスの loadClass メソッドを追う。

クラス名をもとにfindFileを呼び出し、ファイルが見つかったらincludeする。

```php
    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return true|null True if loaded, null otherwise
     */
    public function loadClass($class)
    {
        if ($file = $this->findFile($class)) {
            $includeFile = self::$includeFile;
            $includeFile($file);

            return true;
        }

        return null;
    }
```

findFile は以下のように実装されている。

```php
    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|false The path if found, false otherwise
     */
    public function findFile($class)
    {
        // class map lookup
        if (isset($this->classMap[$class])) {
            return $this->classMap[$class];
        }
        if ($this->classMapAuthoritative || isset($this->missingClasses[$class])) {
            return false;
        }
        if (null !== $this->apcuPrefix) {
            $file = apcu_fetch($this->apcuPrefix.$class, $hit);
            if ($hit) {
                return $file;
            }
        }

        $file = $this->findFileWithExtension($class, '.php');

        // Search for Hack files if we are running on HHVM
        if (false === $file && defined('HHVM_VERSION')) {
            $file = $this->findFileWithExtension($class, '.hh');
        }

        if (null !== $this->apcuPrefix) {
            apcu_add($this->apcuPrefix.$class, $file);
        }

        if (false === $file) {
            // Remember that this class does not exist.
            $this->missingClasses[$class] = true;
        }

        return $file;
    }
```

self::$includeFile は以下のように初期化されている。
```php
    /**
     * @return void
     */
    private static function initializeIncludeClosure()
    {
        if (self::$includeFile !== null) {
            return;
        }

        /**
         * Scope isolated include.
         *
         * Prevents access to $this/self from included files.
         *
         * @param  string $file
         * @return void
         */
        self::$includeFile = \Closure::bind(static function($file) {
            include $file;
        }, null, null);
    }

```

## autoloadの実験

### ファイルごと読み込まれる

例えば、以下のようなファイル構成の場合、Fugaクラスも読み込まれる

public/index.php
```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$hoge = new App\Hoge();
$fuga = new App\Fuga();
```

app/Hoge.php
```php

<?php

namespace App;

class Hoge
{
    public function __construct()
    {
        echo 'Hoge::__construct()' . PHP_EOL;
    }
}

class Fuga
{
    public function __construct()
    {
        echo 'Fuga::__construct()' . PHP_EOL;
    }
}

```

ただ、こうすると本当にFugaクラスを作った時にも、Hogeが読み込まれた後だと、autoloadが読み込まれない（意図してないFugaクラスが読み込まれた状態）ので、このような使い方はしない方が良い。

つまりは、autoloadは、読み込もうとしたクラスが見つからなかった時に、ファイルを探して読み込むというincludeする仕組みなので、ファイルの他の部分も読まれることに注意する必要がある。

### autoloadでは必要ないファイルは読み込まれない（サンプルコードはsample-app3）

例えば、以下のようなコードの場合、Fugaクラスは読み込まれない

index.php
```php
<?php

require __DIR__ . '/../vendor/autoload.php';

if(true) {
    $hoge = new App\Hoge();
} else {
    $fuga = new App\Fuga();
}

```

ifの条件分岐がわからない場合は、autoloadを使わない場合、両方読み込んでおく必要がある

not_using_autoload.php
```php
<?php

require __DIR__ . '/../app/Hoge.php';
require __DIR__ . '/../app/Fuga.php';

if(true) {
    $hoge = new App\Hoge();
} else {
    $fuga = new App\Fuga();
}

```

仮に、fugaクラスのファイルを読み込むのに時間がかかる場合、autoloadを使っている場合は、fugaクラスが必要な処理に入った時のみファイルを読み込むことになるので、オーバーヘッドが減る。

