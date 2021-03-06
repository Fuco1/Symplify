<?php declare(strict_types=1);

namespace Symplify\Tests\PHPUnit\Listener;

use Nette\Utils\FileSystem;
use Nette\Utils\Finder;
use Nette\Utils\Strings;
use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\TestSuite;
use SplFileInfo;

final class ClearLogAndCacheTestListener extends BaseTestListener
{
    public function endTestSuite(TestSuite $testSuite): void
    {
        if ($testSuite->getName()) { // skip for tests, run only for whole Test Suite
            return;
        }

        foreach ($this->getTempDirectories() as $path => $info) {
            FileSystem::delete($path);
        }
    }

    /**
     * @return string[]
     */
    private function getTempDirectories(): array
    {
        $finder = Finder::findDirectories('cache', 'logs')
            ->from(__DIR__ . '/../../../packages');

        $directories = iterator_to_array($finder->getIterator());

        $tempDirectories = array_filter($directories, function (SplFileInfo $file) {
            return ! Strings::contains($file->getPathname(), 'Cache');
        });

        return $tempDirectories;
    }
}
