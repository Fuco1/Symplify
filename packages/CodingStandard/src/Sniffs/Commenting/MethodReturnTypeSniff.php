<?php declare(strict_types=1);

namespace Symplify\CodingStandard\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\FunctionHelper;

final class MethodReturnTypeSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Getters should have @return tag or return type.';

    /**
     * @var string[]
     */
    private $getterMethodPrefixes = ['get', 'is', 'has', 'will', 'should'];

    /**
     * @var File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @var array[]
     */
    private $tokens;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param File $file
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;
        $this->tokens = $file->getTokens();

        if ($this->shouldBeSkipped()) {
            return;
        }

        $file->addError(self::ERROR_MESSAGE, $position, self::class);
    }

    private function shouldBeSkipped(): bool
    {
        if ($this->isGetterMethod() === false) {
            return true;
        }

        if ($this->hasMethodCommentReturn()) {
            return true;
        }

        $returnTypeHint = FunctionHelper::findReturnTypeHint($this->file, $this->position);
        if ($returnTypeHint) {
            return true;
        }

        return false;
    }

    private function isGetterMethod(): bool
    {
        $methodName = $this->file->getDeclarationName($this->position);
        if ($this->isRawGetterName($methodName)) {
            return true;
        }
        if ($this->hasGetterNamePrefix($methodName)) {
            return true;
        }

        return false;
    }

    private function getMethodComment(): string
    {
        if (! $this->hasMethodComment()) {
            return '';
        }
        $commentStart = $this->file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $this->position - 1);
        $commentEnd = $this->file->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $this->position - 1);

        return $this->file->getTokensAsString($commentStart, $commentEnd - $commentStart + 1);
    }

    private function hasMethodCommentReturn(): bool
    {
        $comment = $this->getMethodComment();

        return strpos($comment, '@return') !== false;
    }

    private function hasMethodComment(): bool
    {
        $currentToken = $this->tokens[$this->position];
        $docBlockClosePosition = $this->file->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $this->position);
        if ($docBlockClosePosition === false) {
            return false;
        }
        $docBlockCloseToken = $this->tokens[$docBlockClosePosition];

        return $docBlockCloseToken['line'] === ($currentToken['line'] - 1);
    }

    private function isRawGetterName(string $methodName): bool
    {
        return in_array($methodName, $this->getterMethodPrefixes);
    }

    private function hasGetterNamePrefix(string $methodName): bool
    {
        foreach ($this->getterMethodPrefixes as $getterMethodPrefix) {
            $position = strpos($methodName, $getterMethodPrefix);
            if ($position !== 0 || $position === false) {
                continue;
            }

            $endPosition = strlen($getterMethodPrefix);
            $firstLetterAfterGetterPrefix = $methodName[$endPosition];
            if (ctype_upper($firstLetterAfterGetterPrefix)) {
                return true;
            }
        }

        return false;
    }
}
