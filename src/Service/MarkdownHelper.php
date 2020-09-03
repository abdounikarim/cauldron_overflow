<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $cache;
    private $markdownParser;
    private $isDebug;
    private $logger;

    public function __construct(CacheInterface $cache, MarkdownParserInterface $markdownParser, bool $isDebug, LoggerInterface $mdLogger)
    {
        $this->cache = $cache;
        $this->markdownParser = $markdownParser;
        $this->isDebug = $isDebug;
        $this->logger = $mdLogger;
    }

    public function parse(string $source): string
    {
        if (stripos($source, 'cat') !== false) {
            $this->logger->info('Meow!');
        }

        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
        }
        return $this->cache->get('markdown_'.md5($source), function() use ($source) {
            return $this->markdownParser->transformMarkdown($source);
        });
    }
}
