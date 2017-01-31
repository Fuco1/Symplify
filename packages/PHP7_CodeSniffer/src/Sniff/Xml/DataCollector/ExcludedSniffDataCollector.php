<?php declare(strict_types=1);

namespace Symplify\PHP7_CodeSniffer\Sniff\Xml\DataCollector;

use SimpleXMLElement;
use Symplify\PHP7_CodeSniffer\Exception\Sniff\Naming\InvalidSniffClassException;
use Symplify\PHP7_CodeSniffer\Sniff\Naming\SniffNaming;

final class ExcludedSniffDataCollector
{
    /**
     * @var string[]
     */
    private $excludedSniffCodes = [];

    public function collectFromRuleXmlElement(SimpleXMLElement $ruleXmlElement)
    {
        if (isset($ruleXmlElement->exclude)) {
            $this->addExcludedSniffs($ruleXmlElement->exclude);
        }
    }

    public function addExcludedSniff(string $excludedSniffCode)
    {
        $this->excludedSniffCodes[] = $excludedSniffCode;
    }

    public function addExcludedSniffs(array $excludedSniffCodes)
    {
        $this->excludedSniffCodes = array_merge($this->excludedSniffCodes, $excludedSniffCodes);
    }

    public function isSniffClassExcluded(string $sniffClassName) : bool
    {
        if (empty($sniffClassName)) {
            return true;
        }

        $sniffCode = SniffNaming::guessCodeByClass($sniffClassName);
        return $this->isSniffCodeExcluded($sniffCode);
    }

    public function isSniffCodeExcluded(string $sniffCode) : bool
    {
        return in_array($sniffCode, $this->excludedSniffCodes);
    }
}
