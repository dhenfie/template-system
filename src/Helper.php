<?php

/**
 * @author fajar susilo <fajarsusilo1600@gmail.com>
 * @since 1.0.0
 * @license MIT
 */

use Dhenfie\TemplateSystem\TemplateSystem;

if (!function_exists('section')) {

    /**
     * Alias of TemplateSystem::section()
     *
     * @param  string $section
     * @param  string $content
     * @return void
     */
    function section(string $section, string $content = null): void
    {
        TemplateSystem::getInstance()->section($section, $content);
    }
}

if (!function_exists('endSection')) {

    /**
     * Alias of TemplateSystem::endSection()
     *
     * @return void
     */
    function endSection(): void
    {
        TemplateSystem::getInstance()->endSection();
    }
}


if (!function_exists('renderSection')) {

    /**
     * Alias of TemplateSystem::renderSection()
     *
     * @param string $section
     * @return string
     */
    function renderSection(string $section): string
    {
        return TemplateSystem::getInstance()->renderSection($section);
    }
}


if (!function_exists('extend')) {

    /**
     * Alias of TemplateSystem::extend()
     *
     * @param  string $master
     * @return void
     */
    function extend(string $master)
    {
        TemplateSystem::getInstance()->extend($master);
    }
}

if (!function_exists('stack')) {

    /**
     * Alias of TemplateSystem::stack()
     *
     * @return void
     */
    function stack(): void
    {
        TemplateSystem::getInstance()->stack();
    }
}

if (!function_exists('endStack')) {

    /**
     * Alias of TemplateSystem::endStack()
     *
     * @return void
     */
    function endStack(): void
    {
        TemplateSystem::getInstance()->endStack();
    }
}

if (!function_exists('pushStack')) {

    /**
     * Alias of TemplateSystem::endStack()
     *
     * @return void
     */
    function pushStack(): void
    {
        TemplateSystem::getInstance()->pushStack();
    }
}

if (!function_exists('endPushStack')) {

    /**
     * Alias of TemplateSystem::endPushStack()
     *
     * @return void
     */
    function endPushStack(): void
    {
        TemplateSystem::getInstance()->endPushStack();
    }
}

if (!function_exists('load')) {

    /**
     * Alias of TemplateSystem::load()
     *
     * @param string $file
     * @param array $data
     * @return void
     */
    function load(string $file, array $data = []): void
    {
        TemplateSystem::getInstance()->load($file, $data);
    }
}
