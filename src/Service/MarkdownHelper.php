<?php

namespace App\Service;

class MarkdownHelper
{
    public function __construct()
    {

    }

    public function parse(string $source): string
    {
        return $cache->get('markdown_'.md5($source), function() use ($markdownParser, $source) {
            return $markdownParser->transformMarkdown($source);
        });
    }
}
