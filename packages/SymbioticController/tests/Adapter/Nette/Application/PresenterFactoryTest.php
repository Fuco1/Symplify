<?php declare(strict_types = 1);

namespace Symplify\SymbioticController\Tests\Adapater\Nette\Applicadtion;

use PHPUnit\Framework\TestCase;
use Symplify\SymbioticController\Adapter\Nette\Application\PresenterFactory;
use Symplify\SymbioticController\Tests\ContainerFactory;

final class PresenterFactoryTest extends TestCase
{
    /**
     * @var PresenterFactory
     */
    private $presenterFactory;

    protected function setUp()
    {
        $container = (new ContainerFactory)->create();
        $this->presenterFactory = $container->getByType(PresenterFactory::class);
    }


    /**
     * @todo
     */
    public function test()
    {
//        $this->presenterFactory->createPresenter();
        // ...
    }
}
