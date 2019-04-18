<?php declare(strict_types=1);

namespace Util;

use RuntimeException;

class FileStorage
{
    /** @var string */
    private $outputDir;

    public function __construct(string $outputDir)
    {
        $this->outputDir = $outputDir;
    }

    public function load(string $class): array
    {
        $storageFile = $this->normalizeFileName($class);
        if (!file_exists($storageFile)) {
            return [];
        }

        $storageContents = file_get_contents($storageFile);
        if ($storageContents === false) {
            throw new RuntimeException("Failed to read contents from storage file: {$storageFile}.");
        }

        $deserializedObjects = unserialize($storageContents, ['allowed_classes' => [$class]]);
        if ($deserializedObjects === false) {
            throw new RuntimeException(
                <<<TEXT
                Unable to deserialize contents from storage file: {$storageFile}.
                Most likely the data structure is incompatible. 
                Delete the file and try again.
                TEXT
            );
        }

        return $deserializedObjects;
    }

    public function save(string $class, array $items): void
    {
        $storageFile = $this->normalizeFileName($class);
        $serializedObjects = serialize($items);

        $result = file_put_contents($storageFile, $serializedObjects);
        if ($result === false) {
            throw new RuntimeException("Failed to write contents to storage file: {$storageFile}.");
        }
    }

    private function normalizeFileName(string $class): string
    {
        return rtrim($this->outputDir, '/') . '/' . strtolower(str_replace('\\', '_', $class));
    }
}