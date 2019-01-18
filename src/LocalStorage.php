<?php
/**
 * @copyright 2019 Razon Yang <razonyang@gmail.com>
 */
namespace RazonYang\Yii\ResourceStorage;

use yii\base\InvalidArgumentException;

/**
 * Class LocalStorage
 *
 * @property string $path the resource absolute path.
 */
class LocalStorage extends Storage
{
    /**
     * @var int $mode file mode.
     *
     * @see mkdir()
     */
    public $mode = 0744;

    /**
     * @var string $path the resource absolute path.
     */
    private $path;

    /**
     * Sets resource path.
     *
     * @param string $path
     */
    public function setPath(string $path)
    {
        $path = \Yii::getAlias($path);
        $this->path = rtrim($path, '/') . '/';
    }

    /**
     * Gets resource absolute path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->path)) {
            throw new InvalidArgumentException('The path is required');
        }
    }

    /**
     * @inheritdoc
     *
     * @throws InvalidArgumentException|FileException
     */
    public function uploadFile(string $src, string $dest): string
    {
        if (!is_file($src)) {
            throw new InvalidArgumentException('The source file does not exist: ' . $src);
        }

        $destination = $this->getAbsolutePath($dest);
        $this->mkdir(dirname($destination));

        if (!copy($src, $destination)) {
            throw new FileException('Failed to upload file');
        }

        return $this->getUrl($dest);
    }

    /**
     * @inheritdoc
     */
    public function saveFile(string $content, string $filename): string
    {
        $destination = $this->getAbsolutePath($filename);
        $this->mkdir(dirname($destination));

        if (file_put_contents($destination, $content) === false) {
            throw new \Exception('Failed to save file');
        }

        return $this->getUrl($filename);
    }

    /**
     * @inheritdoc
     *
     * @throws FileNotExistException
     */
    public function deleteFile(string $filename): bool
    {
        $destination = $this->getAbsolutePath($filename);
        if (!is_file($destination)) {
            throw new FileNotExistException('The file does not exist: ' . $destination);
        }

        return unlink($destination);
    }

    /**
     * Creates directory.
     *
     * @param string $dir
     * @param bool $recursive
     * @param bool $throwException
     *
     * @throws FileException
     *
     * @return bool
     */
    protected function mkdir(string $dir, bool $recursive = true, bool $throwException = true): bool
    {
        if (!is_dir($dir) && !mkdir($dir, $this->mode, $recursive)) {
            if ($throwException) {
                throw new FileException('Failed to create directory: ' . $dir);
            }

            return false;
        }

        return true;
    }

    /**
     * Gets absolute path of filename.
     *
     * @param string $path relative path.
     *
     * @return string
     */
    public function getAbsolutePath(string $path): string
    {
        return $this->path . ltrim($path, '/');
    }

    /**
     * Gets resource URL.
     *
     * @param string $dest
     *
     * @return string
     */
    protected function getUrl(string $dest): string
    {
        return $this->host . '/' . ltrim($dest, '/');
    }
}