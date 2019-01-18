<?php
/**
 * @copyright 2019 Razon Yang <razonyang@gmail.com>
 */
namespace RazonYang\Yii\ResourceStorage;

/**
 * Interface StorageInterface
 *
 * @author Razon Yang <razonyang@gmail.com>
 */
interface StorageInterface
{
    /**
     * Uploads source file to the given destination.
     *
     * @param string $src source file.
     * @param string $dest destination file.
     *
     * @return string URL of the file.
     */
    public function uploadFile(string $src, string $dest): string;

    /**
     * Saves files.
     *
     * @param string $content file content.
     * @param string $filename file name.
     *
     * @return string URL of the file.
     */
    public function saveFile(string $content, string $filename): string;

    /**
     * Deletes file.
     *
     * @param string $filename the deleted filename.
     *
     * @return bool
     */
    public function deleteFile(string $filename): bool;

    /**
     * Gets resource host.
     *
     * @return string resource host.
     */
    public function getHost(): string;

    /**
     * Completes resource URL.
     *
     * @param string $path relative path of the resource host.
     *
     * @return string the URL of resource.
     */
    public function completeURL(string $path): string;

    /**
     * Get the relative path that associated with resource host.
     *
     * @param string $url the URL of resource.
     *
     * @return string
     */
    public function getRelativePath(string $url): string;
}