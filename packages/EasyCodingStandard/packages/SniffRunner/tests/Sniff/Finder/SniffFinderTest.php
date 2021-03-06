<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\SniffRunner\Tests\Sniff\Finder;

use PHPUnit\Framework\TestCase;
use Symplify\EasyCodingStandard\SniffRunner\Sniff\Finder\SniffFinder;
use Symplify\PackageBuilder\Adapter\Nette\GeneralContainerFactory;

final class SniffFinderTest extends TestCase
{
    public function test(): void
    {
        $container = (new GeneralContainerFactory)->createFromConfig(
            __DIR__ . '/../../../../../src/config/config.neon'
        );
        $sniffFinder = $container->getByType(SniffFinder::class);
        $this->assertGreaterThan(250, $sniffFinder->findAllSniffClasses());
    }
}
