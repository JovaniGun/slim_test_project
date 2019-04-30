<?php
// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path'], ['cache' => false]);

    // Instantiate and add Slim specific extension
    //$basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    //$view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};
//  $container['router'] = function($c)
//  {
//   return new \Slim\Router();   
//  };
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};
$container["HelloController"] = function ($c) {
    return new \Controllers\HelloController($c);
};
$container["AuthController"] = function ($c) {
    return new \Controllers\AuthController($c);
};
$container["AdminController"] = function ($c) {
    return new \Controllers\AdminController($c);
};
$container["RestoreController"] = function ($c) {
    return new \Controllers\RestoreController($c);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
