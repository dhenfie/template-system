<?php

/**
 * Template System 
 * 
 * @author fajar susilo <fajarsusilo1600@gmail.com>
 * @since 1.0.0
 * @license MIT
 */

declare(strict_types=1);

namespace Dhenfie\TemplateSystem;

use Exception;

final class TemplateSystem
{
    /**
     * default path untuk file template
     *
     * @var string
     */
    protected string $viewPath;

    /**
     * untuk nama section
     *
     * @var array
     */
    protected array $section = array();

    /**
     * section yang sedang aktif
     *
     * @var string|null
     */
    protected ?string $currentSection = null;

    /**
     * file master atau parent yang akan di extend
     *
     * @var string
     */
    protected string $master;

    /** @var array */
    public array $stackScript = [];

    /**
     * singleton instance object agar bekerja di helper
     * 
     * @var self
     */
    protected static $_instance;

    /**
     * Constructor 
     * 
     * @param  string|null $viewPath
     */
    public function __construct(?string $viewPath = null)
    {
        if (!is_null($viewPath)) {
            $this->setViewPath($viewPath);
        }
        self::$_instance = $this;
    }

    /**
     * return view path
     */
    public function getViewPath(): string
    {
        return $this->viewPath;
    }

    /**
     * return file master atau parent
     *
     * @return string
     */
    public function getMaster(): string
    {
        return $this->master;
    }

    /**
     * set root directory untuk view
     *
     * @param  string $viewPath
     * @return void
     */
    public function setViewPath(string $viewPath): void
    {
        if (!is_dir($viewPath)) {
            throw new Exception("root path {$viewPath} not valid ");
        }
        $this->viewPath = realpath($viewPath);
    }

    /**
     * mulai dan buat section
     *
     * @param  string $section
     * @return void
     */
    public function section(string $section): void
    {
        $this->currentSection = $section;
        $this->section[$section] = null;
        ob_start();
    }

    /** 
     * stop sebuah section
     * 
     * @return void
     */
    public function endSection(): void
    {
        $sectionName = $this->currentSection;
        $this->section[$sectionName] = ob_get_contents();
        ob_end_clean();
    }

    /**
     * tampilkan section
     *
     * @param  string $section
     * @return string
     */
    public function renderSection(string $section): string
    {
        if (array_key_exists($section, $this->section)) {
            return $this->section[$section];
        }
        return '';
    }

    /**
     * stack script
     *
     * @return void
     */
    public function stack(): void
    {
        ob_start();
    }

    /**
     * end stack
     *
     * @return void
     */
    public function endStack(): void
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
     * push stack
     *
     * @return void
     */
    public function pushStack(): void
    {
        ob_start();
    }

    /**
     * end push stack
     *
     * @return void
     */
    public function endPushStack(): void
    {
        $content = ob_get_contents();
        ob_end_clean();

        $contentToArray = explode("\n", $content);
        $merged = array_merge($this->stackScript, $contentToArray);
        $this->stackScript = $merged;
    }

    /**
     * pewarisan templates
     *
     * @param  string $master
     * @return void
     */
    public function extend(string $master): void
    {
        if (!file_exists($this->getViewPath() . DIRECTORY_SEPARATOR . $master)) {
            throw new Exception("can't extending file " . basename($master) . " not found");
        }
        $this->master = $master;
    }

    /**
     * load file dan extract variabel jika ada
     *
     * @param  string $file
     * @param  array  $data
     * @return void
     */
    public function load(string $file, array $data = []): void
    {
        if (!file_exists($pathFile = $this->getViewPath() . DIRECTORY_SEPARATOR . $file)) {
            throw new Exception("target file {$pathFile} not found in directory {$this->getViewPath()}");
        }
        (is_array($data) && !empty($data)) ? extract($data) : '';
        include $pathFile;
    }

    /**
     * render template
     *
     * @param  string $file
     * @param  array  $data
     * @return mixed
     */
    public function render(string $file, array $data = [], $return = true): mixed
    {

        if ($return){
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
     * ini mengembalikan instance object saat
     *
     * @return self
     */
    public static function usingInstance()
    {
        return self::$_instance;
    }
}
