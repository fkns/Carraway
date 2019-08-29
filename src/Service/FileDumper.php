<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileDumper
 * @package App\Service
 */
class FileDumper
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $directoryPath;

    /**
     * FileDumper constructor.
     * @param string $directoryPath
     */
    public function __construct(string $directoryPath)
    {
        $this->filesystem = new Filesystem();
        $this->directoryPath = $directoryPath;
    }

    /**
     * @param string $fileName
     * @param string $content
     */
    public function dump(string $fileName, string $content)
    {
        $this->filesystem->dumpFile($this->directoryPath . '/' . $fileName, $content);
    }
}