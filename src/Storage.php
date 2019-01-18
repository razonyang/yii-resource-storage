<?php
/**
 * @copyright 2019 Razon Yang <razonyang@gmail.com>
 */
namespace RazonYang\Yii\ResourceStorage;

use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\base\NotSupportedException;

/**
 * Class Storage
 *
 * @property string $host resource host.
 *
 * @author Razon Yang <razonyang@gmail.com>
 */
class Storage extends BaseObject implements StorageInterface
{
    /**
     * @var string $host resource host.
     */
    private $host;

    /**
     * @inheritdoc
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @throws InvalidArgumentException
     */
    public function setHost(string $host)
    {
        $this->host = rtrim($host, '/');
    }

    /**
     * @inheritdoc
     */
    public function completeURL(string $path): string
    {
        return $this->host . '/' . ltrim($path, '/');
    }

    /**
     * @inheritdoc
     */
    public function getRelativePath(string $url): string
    {
        return ltrim(str_replace($this->host, '', $url), '/');
    }

    /**
     * @inheritdoc
     */
    public function uploadFile(string $src, string $dest): string
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     */
    public function saveFile(string $content, string $filename): string
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }

    /**
     * @inheritdoc
     */
    public function deleteFile(string $filename): bool
    {
        throw new NotSupportedException(__METHOD__ . ' is not supported.');
    }
}