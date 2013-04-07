<?php
namespace BalExceptions\Options;

use \Zend\Stdlib\AbstractOptions;

/**
 * The options for the BalException module
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Padding withn an exception
     *
     * @var int
     */
    protected $padding = 8;

    /**
     * Render trace enabled
     *
     * @var boolean
     */
    protected $traceEnabled = true;

    /**
     * The padding for an exception
     *
     * @param int $padding
     */
    public function setPadding($padding)
    {
        $this->padding = $padding;
    }

    /**
     * The padding for an exception
     *
     * @return int
     */
    public function getPadding()
    {
        return $this->padding;
    }

    /**
     * Get if the trace rendering is enabled
     *
     * @return Boolean
     */
    public function getTraceEnabled()
    {
        return $this->traceEnabled;
    }

    /**
     * Enable / Disable trace rendering
     *
     * @param boolean
     * @return BalExceptions\Options\ModuleOptions
     */
    public function setTraceEnabled($value)
    {
        $this->traceEnabled = $value;

        return $this;
    }

    public function setView($what)
    {
        var_dump(func_get_args());
    }
}