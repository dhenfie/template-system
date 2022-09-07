<?php

use Dhenfie\TemplateSystem\TemplateSystem;
use PHPUnit\Framework\TestCase;

class TemplateSystemTest extends TestCase
{
    protected TemplateSystem $templateSystem;

    protected function setUp(): void
    {
        $this->templateSystem = new TemplateSystem();
    }

    public function testValidViewPathViaConstructor(): void
    {
        $myLib = new TemplateSystem('example');
        $this->assertSame(realpath('example'), $myLib->getViewPath());
    }

    public function testValidSetViewPath(): void
    {
        $this->templateSystem->setViewPath('example');
        $this->assertSame(realpath('example'), $this->templateSystem->getViewPath());
    }

    public function testNotValidViewPathViaConstructor(): void
    {
        $this->expectException(Exception::class);
        $myLib = new TemplateSystem('dir_empty');
    }

    public function testNotValidSetViewPath(): void
    {
        $this->expectException(Exception::class);
        $this->templateSystem->setViewPath('dir_empty');
    }

    public function testRenderSection(): void
    {
        $this->expectOutputString('first section content');
        echo $this->exampleRender('first', 'first section content');
    }

    public function testRenderSectionKeyNotExists(): void
    {
        $this->expectOutputString('');
        $this->templateSystem->section('section');
        echo 'this section content';
        $this->templateSystem->endSection();
        echo $this->templateSystem->renderSection('wrong_section');
    }

    public function testExtend(): void
    {
        $this->templateSystem->setViewPath('example');
        $this->templateSystem->extend('master.php');
        $this->assertSame('master.php', $this->templateSystem->getMaster());
    }

    public function testExtendFileNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->templateSystem->setViewPath('example');
        $this->templateSystem->extend('master_not_valid');
    }

    public function testLoad(): void
    {
        $this->templateSystem->setViewPath('example');
        $this->templateSystem->load('testLoad.php');
        $this->expectOutputString($this->exampleGetContent());
    }

    public function testLoadWithData(): void
    {
        $this->templateSystem->setViewPath('example');
        $this->templateSystem->load('testLoad.php', ['name' => 'welcome']);
        $this->expectOutputString($this->exampleGetContent(['name' => 'welcome']));
    }

    public function testLoadFileNotFound(): void
    {
        $this->expectException(Exception::class);
        $this->templateSystem->setViewPath('example');
        $this->templateSystem->load('file_not_found.php');
    }

    public function testStack(): void
    {
        $this->templateSystem->setViewPath('example');
        $this->templateSystem->pushStack();
        echo "stack 1\n";
        echo "stack 2";
        $this->templateSystem->endPushStack();
        $this->templateSystem->stack();
        echo "stack 3\n";
        echo "stack 4";
        $this->templateSystem->endStack();
        $this->assertTrue(true);
    }

    public function testUsingInstance(): void
    {
        $this->templateSystem->setViewPath('example');
        $instance = TemplateSystem::usingInstance();
        $this->assertSame($this->templateSystem->getViewPath(), $instance->getViewPath());
    }

    public function exampleRender(string $section, string $content): string
    {
        $this->templateSystem->section($section);
        echo $content;
        $this->templateSystem->endSection();
        return $this->templateSystem->renderSection($section);
    }

    public function exampleGetContent(array $data = []): string
    {
        extract($data);
        ob_start();
        require './example/testLoad.php';
        $expected = ob_get_contents();
        ob_end_clean();
        return $expected;
    }
}
