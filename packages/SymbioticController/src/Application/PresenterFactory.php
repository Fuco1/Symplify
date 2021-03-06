<?php declare(strict_types=1);

namespace Symplify\SymbioticController\Application;

use Nette\Application\IPresenter;
use Nette\Application\IPresenterFactory;
use Nette\Application\UI\Presenter;
use Nette\DI\Container;
use Symplify\SymbioticController\Application\Routing\PresenterMapper;
use Symplify\SymbioticController\Application\Validator\PresenterGuardian;

final class PresenterFactory implements IPresenterFactory
{
    /**
     * @var string[]
     */
    private $cache = [];

    /**
     * @var Container
     */
    private $container;

    /**
     * @var PresenterMapper
     */
    private $presenterMapper;

    /**
     * @var PresenterGuardian
     */
    private $presenterGuardian;

    public function __construct(
        Container $container,
        PresenterMapper $presenterMapper,
        PresenterGuardian $presenterGuardian
    ) {
        $this->container = $container;
        $this->presenterMapper = $presenterMapper;
        $this->presenterGuardian = $presenterGuardian;
    }

    /**
     * @param string $name
     * @return IPresenter|callable|object
     */
    public function createPresenter($name)
    {
        $presenterClass = $this->getPresenterClass($name);
        $presenter = $this->container->createInstance($presenterClass);

        if ($presenter instanceof Presenter) {
            $this->container->callInjects($presenter);
        }

        return $presenter;
    }

    /**
     * @param string $presenterName
     */
    public function getPresenterClass(&$presenterName): string
    {
        if (isset($this->cache[$presenterName])) {
            return $this->cache[$presenterName];
        }

        $this->presenterGuardian->ensurePresenterNameIsValid($presenterName);

        $presenterClass = $this->presenterMapper->detectPresenterClassFromPresenterName($presenterName);

        $this->ensurePresenterClassIsValid($presenterName, $presenterClass);

        return $this->cache[$presenterName] = $presenterClass;
    }

    /**
     * @param string[][]
     */
    public function setMapping(array $mapping): void
    {
        $this->presenterMapper->setMapping($mapping);
    }

    private function ensurePresenterClassIsValid(string $presenterName, string $presenterClass): void
    {
        $this->presenterGuardian->ensurePresenterClassExists($presenterName, $presenterClass);
        $this->presenterGuardian->ensurePresenterClassIsNotAbstract($presenterName, $presenterClass);
    }
}
