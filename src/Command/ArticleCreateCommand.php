<?php

namespace App\Command;

use App\Service\FileDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ArticleCreateCommand
 * @package App\Command
 */
class ArticleCreateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'carraway:article:create';

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FileDumper
     */
    private $fileDumper;

    /**
     * ArticleCreateCommand constructor.
     * @param Environment $twig
     * @param FileDumper $fileDumper
     */
    public function __construct(Environment $twig, FileDumper $fileDumper)
    {
        $this->twig = $twig;
        $this->fileDumper = $fileDumper;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates a new article.')
            ->setHelp('This command allows you to create an article.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = new \DateTime();

        $string = $this->twig->render('template/article.md.twig', [
            'layout' => 'article',
            'title' => $date->format('YmdHis'),
            'date' => $date->format('Y/m/d H:i:s'),
            'category' => 'category1',
            'tags' => ['tag1', 'tag2'],
            'permalink' => 'permalink',
            'published' => true,
        ]);

        $filename = sprintf('%s.md', $date->format('YmdHis'));
        $this->fileDumper->dump($filename, $string);
    }
}