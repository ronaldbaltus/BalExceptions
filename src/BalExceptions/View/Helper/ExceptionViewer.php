<?php

namespace BalExceptions\View\Helper;

use BalExceptions\Options\ModuleOptions;
use Zend\View\Helper\AbstractHelper;

class ExceptionViewer extends AbstractHelper
{
    /**
     * @var BalExceptions\Options\ModuleOptions
     */
    protected $options;

    public function __construct(ModuleOptions $options)
    {
        $this->options = $options;
    }

    /**
     * Get the module options
     * @param BalExceptions\Options\ModuleOptions
     *
     * @return BalExceptions\View\Helper\ExceptionViewer
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get the module options
     * @return BalExceptions\Options\ModuleOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Generate a simple row
     *
     * @param $label
     * @param $value
     * @param string $classname css classname
     */
    protected function generateRow($label, $value, $classname="")
    {
        $value = "<span class=\"exception_value {$classname}\">{$value}</span>";

        if (is_string($label)) {
            $label = "<span class=\"exception_label\">{$label}</span>";
        }

        return "<div class=\"exception_row\">{$label}{$value}</div>";
    }

    /**
     * This method prints the file, line and actual code.
     * @param string file
     * @param int line
     * @param string errormessage
     */
    protected function generateErrorMessage($file, $line, $exception=false)
    {
        if (is_object($exception)) {
            $message = $exception->getMessage();
        } else if (is_string($exception)) {
            $message = $exception;
        } else {
            $message = false;
        }

        $html = '<div class="exception">';
        if (is_object($exception)) {
            $html .=  "<div class=\"exception_row\"><h3 class=\"classname\">".get_class($exception)."</h3></div>";
        }

        if ($message) {
            $html .= $this->generateRow("Message", $message, "message");
        }

        $html .= $this->generateRow("File", "<a href=\"file://{$file}\">{$file}</a>", "file");
        $html .= $this->generateRow("Line", $line, "line");

        if (false) {
            $html .= $this->generateRow(null, "<a href=\"#\">show code</a>", "showcode");
            $html .= $this->generateCode($file, $line);
        } else {
            // Add the code block
            $html .= $this->generateCode($file, $line);
        }

        // closing tag.
        return $html . "</div>";
    }

    /**
     * Shows the actual code and highlights the line.
     * @param string file
     * @param int line
     * @return string html code
     */
    protected function generateCode($file, $line)
    {
        $padding = $this->getOptions()->getPadding();

        // open the source file
        $source = file_get_contents($file);
        $source = str_replace("\r\n", "\n", $source);
        $lines = explode("\n", $source);

        // Calculate line settings
        $lastline = min($line + $padding, count($lines));
        $firstline = max($line - $padding, 0);

        $source = "";
        // echo the line
        for ($i = $firstline; $i < $lastline; $i++) {
            if (($i + 1) === $line) {
                preg_match('/^(\s+)?(.*)/', $lines[$i], $matches);
                if (count($matches) > 2) {
                    $source .= $matches[1].'<span class="highlight">'.$matches[2].'</span>'.PHP_EOL;
                } else {
                    $source .= $lines[$i].PHP_EOL;
                }
            } else {
                $source .= $lines[$i].PHP_EOL;
            }
        }

        return "<pre class=\"code prettyprint linenums:".($firstline+1)."\">{$source}</pre>";
    }

    /**
     * Render an array of error messages.
     *
     * @param Array
     * @return string
     */
    protected function renderTraceArray(array $traceItems)
    {
        $retval = array();

        foreach ($traceItems as $trace) {

            if (!isset($trace["file"])) {
                $retval[] = var_export($trace, true);

            } else {
                $retval[] = $this->generateErrorMessage($trace["file"], $trace["line"]);
            }
        }

        return implode("\n\n", $retval);
    }

    /**
     * Render the exception
     *
     * @return string
     */
    public function __invoke(\Exception $exception)
    {
        $retval = array();

        $retval[] = $this->generateErrorMessage(
            $exception->getFile(),
            $exception->getLine(),
            $exception
        );

        if ($this->getOptions()->getTraceEnabled()) {
            $retval[] = $this->renderTraceArray($exception->getTrace());
        }

        return implode($retval);
    }
}