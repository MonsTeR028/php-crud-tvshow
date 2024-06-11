<?php

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
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
                 <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
                 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                <div class="header" data-aos="zoom-in">
                    {$this->getHome()}
                    <h1>{$this->getTitle()}</h1>
                </div>
                <div class="content" data-aos="zoom-out-left">
                    <div class="menu">
                        {$this->getMenu()}
                    </div>
                    <div class="list">
                    {$this->getBody()}
                    </div>
                </div>
            <div class="footer">$lastModification</div> 
            <script>
              AOS.init();
            </script>
            </body>
        </html>
        HTML;
    }
}
