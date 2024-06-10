<?php

namespace Html;

class AppWebPage extends WebPage
{
    private string $menu;
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
        $this->menu = "";
    }

    public function appendToMenu(string $content): void
    {
        $this->menu .= $content;
    }

    public function toHtml(): string
    {
        $lastModification = WebPage::getLastModification();
        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport"
                 content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                 <link rel="icon" href="img/favicon.ico">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                <div class="header"><h1>{$this->getTitle()}</h1></div>
                <div class="content">
                    <div class="menu">
                        {$this->menu}
                    </div>
                    <div class="list">
                    {$this->getBody()}
                    </div>
                </div>
            <div class="footer">$lastModification</div> 
            </body>
        </html>
        HTML;
    }
}
