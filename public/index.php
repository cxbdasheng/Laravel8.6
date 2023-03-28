<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

// 定义运行时间
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| 检查应用程序是否正在维护中
|--------------------------------------------------------------------------
| 如果应用程序通过 “down” 命令处于 维护或演示 模式
| 我们将加载此文件，以便可以显示任何预先渲染的内容
| 而不是启动框架，这可能会导致异常。
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| 注册自动加载器
|--------------------------------------------------------------------------
| Composer为这个应用程序提供了一个方便的、自动生成的类加载器。
| 我们只需要利用它！我们只需要在这里将其放入脚本中，这样我们就不需要手动加载类了。
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| 运行应用程序
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
