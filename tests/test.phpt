<?php
namespace Test;

use Nette;
use Tester;
use Tester\Assert;
use Tester\TestCase;


$container = require __DIR__ . '/bootstrap.php';

class Test extends TestCase
{
    private $container;
    private $staticPage;

    public function __construct(Nette\DI\Container $container)
    {
        $this->container = $container;
        $this->staticPage = $this->container->getByType('VladimirBiro\StPage\StaticPage');


    }

    public function setUp()
    {
        $this->staticPage->setStaticPageById(1);
        $this->staticPage->deleteStaticPage(1);

        $this->staticPage->addStaticPage([
            'id' => 1,
            'title' => 'titulka',
            'content' => 'Nejaky obsah'
        ]);
    }

    public function testUserManager()
    {
        $this->staticPage->setStaticPageById(1);

        $return = $this->staticPage->getStaticPage();
        Assert::same('titulka', $return->title);
        Assert::same('Nejaky obsah', $return->content);
    }
}

$test = new Test($container);
$test->run();