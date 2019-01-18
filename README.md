# Resource Storage Component for Yii Framework

This library aim to be an universal resource storage component that provides the most commonly used APIs to manager resources, such as:
**uploadFile**, **saveFile** and **deleteFile** etc.

## Storages

- [LocalStorage](src/LocalStorage.php)

Feel free to add your storage here by PR.

> Any storage **MUST** implements [StorageInterface](src/StorageInterface.php).

## Install

```
$ composer require razonyang/yii-resource-storage
```


## Usage

We take **LocalStorage** as example to explain how to use it.

```php
/** @var StorageInterface $storage */
$storage = Yii::$app->get('resourceStorage');
```

### Config

```php
return [
    'components' => [
        'resourceStorage' => [
            'class' => \RazonYang\Yii\ResourceStorage\LocalStorage::class,
            'host' => 'http://localhost',
            'path' => '@app/web',
        ],
    ],
];
```

### Uploads File

```php
$src = __DIR__ . '/foo.jpg';
$dest = 'foo.jpg';
$url = $storage->uploadFile($src, $dest);
echo $url; // http://localhost/foo.jpg
```

### Saves file

```php
$content = 'bar';
$filename = 'bar.txt';
$url = $storage->saveFile($content, $filename);
echo $url; // http://localhost/bar.txt
```

### Deletes file

```php
$filename = 'foo.jpg';
try {
    $deleted = $storage->deleteFile($deleteFile);
    if (!$deleted) {
        throw new \Exception('Failed to deleted file: ' . $filename);
    }

} catch (FileNotExistException $e) {
    // Handles FileNotExistException
} catch (\Throwable $t) {
    // Handles other error or exception.
}
```