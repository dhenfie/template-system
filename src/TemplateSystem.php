<?php

/**
 * Template System
 *
 * @author fajar susilo <fajarsusilo1600@gmail.com>
 * @since 1.0.0
 * @license MIT
 */

namespace Dhenfie\TemplateSystem;

use Exception;

final class TemplateSystem
{
    /**
     * location view path
     *
     * @var string
     */
    protected string $viewPath;

    /**
     * section name used by block
     *
     * @var array
     */
    protected array $section = array();

    /**
     * the current section
     *
     * @var string|null
     */
    protected ?string $currentSection = null;

    /**
     * file master template
     *
     * @var string
     */
    protected string $master;

    /**
     * array of tag script
     *
     * @var array
     */
    public array $stackScript = [];

    /**
     * the instance of class TemplateSystem
     *
     * @var self
     */
    protected static $_instance;

    /**
     * The Constructor class
     *
     * @param  string|null $viewPath
     */
    public function __construct(?string $viewPath = null)
    {
        if (! is_null($viewPath)) {
            $this->setViewPath($viewPath);
        }
        self::$_instance = $this;
    }

    /**
     * Returns the view path.
     *
     * @return string
     */
    public function getViewPath() : string
    {
        return $this->viewPath;
    }

    /**
     * Returns the template master.
     *
     * @return string
     */
    public function getMaster() : string
    {
        return $this->master;
    }

    /**
     * Set root directory for template
     *
     * @param  string $viewPath
     * @return void
     */
    public function setViewPath(string $viewPath) : void
    {
        if (! is_dir($viewPath)) {
            throw new Exception("root path {$viewPath} not valid ");
        }
        $this->viewPath = realpath($viewPath);
    }

    /**
     * start and create new block section
     *
     * @param  string $section the section name
     * @return void
     */
    public function section(string $section) : void
    {
        $this->currentSection    = $section;
        $this->section[$section] = null;
        ob_start();
    }

    /**
     * end the section
     *
     * @return void
     */
    public function endSection() : void
    {
        $sectionName                 = $this->currentSection;
        $this->section[$sectionName] = ob_get_contents();
        ob_end_clean();
    }

    /**
     * render or show block section by name section
     *
     * @param  string $section the section name
     * @return string Return the value of defined block section or empty string if block section name not defined
     */
    public function renderSection(string $section) : string
    {
        if (array_key_exists($section, $this->section)) {
            return $this->section[$section];
        }
        return '';
    }

    /**
     * start and create new block section for stack script
     *
     * @return void
     */
    public function stack() : void
    {
        ob_start();
    }

    /**
     * end block section for stack script
     *
     * @return void
     */
    public function endStack() : void
    {
        $content = ob_get_contents();
        ob_end_clean();
        $contentToArray = explode("\n", $content);

        foreach ($contentToArray as $prependContent) {
            echo $prependContent;
        }

        foreach ($this->stackScript as $appendContent) {
            echo $appendContent;
        }
    }

    /**
     * push or add new tags script in section
     *
     * @return void
     */
    public function pushStack() : void
    {
        ob_start();
    }

    /**
     * end or stop pushing tags script
     *
     * @return void
     */
    public function endPushStack() : void
    {
        $content = ob_get_contents();
        ob_end_clean();

        $contentToArray    = explode("\n", $content);
        $merged            = array_merge($this->stackScript, $contentToArray);
        $this->stackScript = $merged;
    }

    /**
     * Template inheritance
     *
     * @param  string $master
     * @return void
     */
    public function extend(string $master) : void
    {
        if (! file_exists($this->getViewPath() . DIRECTORY_SEPARATOR . $master)) {
            throw new Exception("can't extending file " . basename($master) . " not found");
        }
        $this->master = $master;
    }

    /**
     * include file and extract data
     *
     * @param  string $file
     * @param  array  $data
     * @return void
     */
    public function load(string $file, array $data = []) : void
    {
        if (! file_exists($pathFile = $this->getViewPath() . DIRECTORY_SEPARATOR . $file)) {
            throw new Exception("target file {$pathFile} not found in directory {$this->getViewPath()}");
        }
        (is_array($data) && ! empty($data)) ? extract($data) : '';
        include $pathFile;
    }

    /**
     * render template
     *
     * @param  string $file
     * @param  array  $data
     * @return mixed
     */
    public function render(string $file, array $data = [], $return = true) : mixed
    {

        if ($return) {

            ob_start();

            $this->load($file, $data);

            if (isset($this->master)) {
                $this->load($this->getMaster(), $data);
            }

            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }

        $this->load($file, $data);

        if (isset($this->master)) {
            $this->load($this->getMaster(), $data);
        }
    }

    /**
     * Return the instance of class TemplateSystem
     *
     * @return self
     */
    public static function usingInstance()
    {
        return self::$_instance;
    }
}
