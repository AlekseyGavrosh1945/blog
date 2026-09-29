<?php

declare(strict_types=1);

namespace App;

use Smarty;

class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $root = dirname(__DIR__);

        $smarty = new Smarty();
        $smarty->setTemplateDir($root . '/templates');
        // скомпилированные шаблоны храним вне проекта, чтобы не думать о правах на запись
        $smarty->setCompileDir(sys_get_temp_dir() . '/blog_compiled');
        $smarty->registerPlugin('modifier', 'date_ru', 'date_ru');
        $smarty->registerPlugin('modifier', 'plural', 'plural_ru');

        $this->smarty = $smarty;
    }

    public function render(string $template, array $variables = []): void
    {
        foreach ($variables as $name => $value) {
            $this->smarty->assign($name, $value);
        }

        $this->smarty->display($template);
    }
}
