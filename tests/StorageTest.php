<?php
/**
 * @copyright 2019 Razon Yang <razonyang@gmail.com>
 */

use PHPUnit\Framework\TestCase;
use RazonYang\Yii\ResourceStorage\Storage;

class StorageTest extends TestCase
{
    public $host = 'http://localhost/';

    /**
     * @var Storage
     */
    public $storage;

    public function setUp()
    {
        parent::setUp();

        $this->storage = new Storage([
            'host' => $this->host
        ]);
    }

    /**
     */
    public function testGetHost()
    {
        $this->assertEquals(rtrim($this->host, '/'), $this->storage->getHost());
    }

    public function pathsProviders()
    {
        return [
            ['foo.jpg', $this->host . 'foo.jpg'],
            ['bar.png', $this->host . 'bar.png'],
        ];
    }

    /**
     * @param string $path
     * @param string $url
     *
     * @dataProvider pathsProviders
     */
    public function testCompleteUrl($path, $url)
    {
        $this->assertEquals($url, $this->storage->completeURL($path));
    }

    /**
     * @param string $path
     * @param string $url
     *
     * @dataProvider pathsProviders
     */
    public function testGetRelativePath($path, $url)
    {
        $this->assertEquals($path, $this->storage->getRelativePath($url));
    }
}