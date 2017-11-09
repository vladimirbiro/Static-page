<?php
require __DIR__ . '/../vendor/autoload.php';
Tester\Environment::setup();
$configurator = new Nette\Configurator;
$configurator->setDebugMode(false);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
    ->addDirectory(__DIR__ . '/../src')
    ->register();
$configurator->addConfig(__DIR__ . '/../config/config.neon');
$configurator->addConfig(__DIR__ . '/../config/config.local.neon');
return $configurator->createContainer();