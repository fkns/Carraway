<?php

namespace App\Command;

use App\CacheHandler\CacheHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand as ParentCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Clear and Warmup the cache.
 */
class CacheClearCommand extends ParentCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'carraway:cache:clear';

    private $cacheHandler;

    /**
     * CacheClearCommand constructor.
     * @param CacheClearerInterface $cacheClearer
     * @param Filesystem|null $filesystem
     * @param CacheHandlerInterface $cacheHandler
     */
    public function __construct(CacheClearerInterface $cacheClearer, CacheHandlerInterface $cacheHandler, ?Filesystem $filesystem = null)
    {
        parent::__construct($cacheClearer, $filesystem);

        $this->cacheHandler = $cacheHandler;
    }

    /**
     *
     */
    protected function configure()
    {
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        
        $response = $this->cacheHandler->purge();

        $io = new SymfonyStyle($input, $output);
        $io->comment($response->toArray());
    }
}
