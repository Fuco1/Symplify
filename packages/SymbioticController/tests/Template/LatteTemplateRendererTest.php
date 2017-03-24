<?php declare(strict_types = 1);

namespace Symplify\SymbioticController\Tests\Template;

use PHPUnit\Framework\TestCase;
use Symplify\SymbioticController\Template\LatteTemplateRenderer;
use Symplify\SymbioticController\Tests\ContainerFactory;

final class LatteTemplateRendererTest extends TestCase
{
    /**
     * @var LatteTemplateRenderer
     */
    private $latteTemplateRenderer;

    protected function setUp(): void
    {
        $container = (new ContainerFactory)->create();
        $this->latteTemplateRenderer = $container->getByType(LatteTemplateRenderer::class);
    }

    public function testRenderFile(): void
    {
        $renderedTemplate = $this->latteTemplateRenderer->renderFileWithParameters(
            __DIR__ . '/LatteTemplateRendererSource/default.latte'
        );

        $this->assertSame('Some template', trim($renderedTemplate));
    }

    public function testRenderFileWithParameters(): void
    {
        $renderedTemplate = $this->latteTemplateRenderer->renderFileWithParameters(
            __DIR__ . '/LatteTemplateRendererSource/defaultWithParameter.latte',
            [
                'key' => 'value'
            ]
        );

        $this->assertSame('Some value', trim($renderedTemplate));
    }
}
