<?php

namespace Nanbando\Tests\Unit\Core\Database;

use Nanbando\Core\Database\PropertyNotExistsException;
use Nanbando\Core\Database\ReadonlyDatabase;
use PHPUnit\Framework\TestCase;

class ReadonlyDatabaseTest extends TestCase
{
    /**
     * @var ReadonlyDatabase
     */
    protected $database;

    /**
     * @var array
     */
    protected $data = ['name' => 'nanbando'];

    protected function setUp()
    {
        $this->database = new ReadonlyDatabase($this->data);
    }

    public function testGet()
    {
        $this->assertEquals($this->data['name'], $this->database->get('name'));
    }

    public function testGetAll()
    {
        $this->assertEquals($this->data, $this->database->getAll());
    }

    public function testGetNotExisting()
    {
        $this->expectException(PropertyNotExistsException::class);

        $this->database->get('version');
    }

    public function provideGetWithDefaultData()
    {
        return [
            ['name', null, 'nanbando'],
            ['name', 'test', 'nanbando'],
            ['version', 'test', 'test'],
            ['version', null, null],
        ];
    }

    /**
     * @dataProvider provideGetWithDefaultData
     */
    public function testGetWithDefault($name, $default, $expected)
    {
        $this->assertEquals($expected, $this->database->getWithDefault($name, $default));
    }

    public function provideExistsData()
    {
        return [
            ['name', true],
            ['version', false],
        ];
    }

    /**
     * @dataProvider provideExistsData
     */
    public function testExists($name, $expected)
    {
        $this->assertEquals($expected, $this->database->exists($name));
    }
}
