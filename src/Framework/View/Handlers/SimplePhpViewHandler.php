<?php

declare(strict_types=1);

namespace Framework\View\Handlers;

class SimplePhpViewHandler implements \Framework\Contracts\ViewHandler
{
    // file paths where are all the views
    private static string $extention = '#.simplephp.php#';

    public function canHandle(string $viewName): bool
    {
        $res = preg_match_all(static::$extention, $viewName);
        return !($res === false || $res > 1);
    }

    public function handle(string $viewPath, array $data): string
    {
        extract($data);

        ob_start();
        include __DIR__ . '/../../../../resources/' .$viewPath;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

}