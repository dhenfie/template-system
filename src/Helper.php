<?php

/**
 * @author fajar susilo <fajarsusilo1600@gmail.com>
 * @since 1.0.0
 * @license MIT
 */

use Dhenfie\TemplateSystem\TemplateSystem;

if (!function_exists('section')) {

    /**
     * alias TemplateSystem::section()
     *
     * @param  string $section
     * @return void
     */
    function section(string $section): void
    {
        TemplateSystem::usingInstance()->section($section);
    }
}

if (!function_exists('endSection')) {

    /**
     * alias TemplateSystem::endSection()
     *
     * @return void
     */
    function endSection(): void
    {
        TemplateSystem::usingInstance()->endSection();
    }
}


if (!function_exists('renderSection')) {

    function renderSection(string $section): string
    {
        return TemplateSystem::usingInstance()->renderSection($section);
    }
}


if (!function_exists('extend')) {

    /**
     * alis TemplateSystem::extend()
     *
     * @param  string $master
     * @return void
     */
    function extend(string $master)
    {
        TemplateSystem::usingInstance()->extend($master);
    }
}

if (!function_exists('stack')) {

    /**
     * alias TemplateSystem::stack()
     *
     * @return void
     */
    function stack(): void
    {
        TemplateSystem::usingInstance()->stack();
    }
}

if (!function_exists('endStack')) {

    /**
     * alias TemplateSystem::endStack()
     *
     * @return void
     */
    function endStack(): void
    {
        TemplateSystem::usingInstance()->endStack();
    }
}

if (!function_exists('pushStack')) {

    /**
     * alias TemplateSystem::endStack()
     *
     * @return void
     */
    function pushStack(): void
    {
        TemplateSystem::usingInstance()->pushStack();
    }
}

if (!function_exists('endPushStack')) {

    /**
     * alias TemplateSystem::endPushStack()
     *
     * @return void
     */
    function endPushStack(): void
    {
        TemplateSystem::usingInstance()->endPushStack();
    }
}

if (!function_exists('load')) {
    
    /**
     * alias TemplateSystem::load()
     *
     * @param string $file
     * @param array $data
     * @return void
     */
    function load(string $file, array $data = []): void
    {
        TemplateSystem::usingInstance()->load($file, $data);
    }
}
