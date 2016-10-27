<?php

namespace TwigWrapperProvider\Processors;

use DOMDocument;
use DOMNode;
use PageSpecificCss\Twig\Extension as CriticalCssExtension;
use Twig_Environment;
use Twig_Error_Runtime;

class CriticalCssProcessor implements PostProcessorInterface
{

    /**
     * @param string $rawHtml
     *
     * @param string $name Template name
     * @param array $context The context used to render the template
     * @param Twig_Environment|null $environment The twig environment used, useful for accessing
     *
     * @return string processedHtml
     */
    public function process($rawHtml, $name = '', $context = [], $environment = null)
    {
        /** @var CriticalCssExtension $criticalCssExtension */
        try {

            $criticalCssExtension = $environment->getExtension(CriticalCssExtension::class);
            $criticalCss = $criticalCssExtension->getCriticalCss();
            if (strlen($criticalCss) == 0) {
                return $rawHtml;
            }
        } catch (Twig_Error_Runtime $tew) {
            error_log($tew->getMessage());
            return $rawHtml;
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $document->loadHTML(mb_convert_encoding($rawHtml, 'HTML-ENTITIES', 'UTF-8'));
        libxml_use_internal_errors($internalErrors);
        $document->formatOutput = true;

        $headStyle = new DOMNode();
        $headStyle->textContent = "<style type='text/css'>{$criticalCss}</style>";

        $document->getElementsByTagName('head')->item(0)->appendChild($headStyle);


        return $document->textContent;
    }
}