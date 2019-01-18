<?php
/**
 * @copyright 2019 Razon Yang <razonyang@gmail.com>
 */

use PHPUnit\Framework\TestCase;
use RazonYang\Yii\ResourceStorage\LocalStorage;

class LocalStorageTest extends TestCase
{
    public static $host = 'http://localhost/';

    public static $path = __DIR__ . '/tmp';

    /**
     * @var LocalStorage
     */
    public static $storage;

    public static function filesProvider()
    {
        return [
            ['src1', 'dest1', self::$host . 'dest1'],
            ['src2', 'dest2', self::$host . 'dest2'],
        ];
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$storage = new LocalStorage([
            'host' => self::$host,
            'path' => self::$path,
        ]);

        if (!is_dir(self::$path) && !mkdir(self::$path)) {
            throw new RuntimeException('Failed to create temporary directory');
        }

        foreach (self::filesProvider() as $file) {
            $filename = self::$path . '/' . $file[0];
            if (file_put_contents($filename, $file[0]) === false) {
                throw new RuntimeException('Failed to create temporary file: ' . $filename);
            }
        }
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        foreach (self::filesProvider() as $file) {
            $filename = self::$path . '/' . $file[0];
            unlink($filename);
        }

        rmdir(self::$path);
    }

    /**
     * @param string $src
     * @param string $dest
     * @param string $url
     *
     * @dataProvider filesProvider
     */
    public function testUploadFile($src, $dest, $url)
    {
        $this->assertEquals($url, self::$storage->uploadFile(self::$path . '/' . $src, $dest));
    }

    public function saveFilesProvider()
    {
        return [
            ['foo', 'foo.txt', self::$host . 'foo.txt'],
            ['bar', 'bar.txt', self::$host . 'bar.txt'],
        ];
    }

    /**
     * @param string $content
     * @param string $filename
     * @param string $url
     *
     * @dataProvider saveFilesProvider
     */
    public function testSaveFile($content, $filename, $url)
    {
        $this->assertEquals($url, self::$storage->saveFile($content, $filename));
        $this->assertEquals($content, file_get_contents(self::$storage->getAbsolutePath($filename)));
    }


    /**
     * @depends testUploadFile
     * @depends testSaveFile
     */
    public function testDeleteFile()
    {
        $files = [];

        $uploadFiles = self::filesProvider();
        foreach ($uploadFiles as $uploadFile) {
            $files[] = $uploadFile[1];
        }

        $saveFiles = $this->saveFilesProvider();
        foreach ($saveFiles as $saveFile) {
            $files[] = $saveFile[1];
        }

        foreach ($files as $file) {
            $filename = self::$storage->getAbsolutePath($file);
            $this->assertTrue(self::$storage->deleteFile($file));
            $this->assertFalse(file_exists($filename));
        }
    }
}