<?php

namespace App\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $cache;
    private $markdownParser;

    public function __construct(CacheInterface $cache, MarkdownParserInterface $markdownParser)
    {
        $this->cache = $cache;
        $this->markdownParser = $markdownParser;
    }

    public function parse(string $source): string
    {
        return $this->cache->get('markdown_'.md5($source), function() use ($source) {
            return $this->markdownParser->transformMarkdown($source);
        });
    }
}
