<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    use StringEscaper;
    private string $head;
    private string $home;
    private string $title;
    private string $body;
    private string $menu;

    public function __construct(string $title = '')
    {
        $this->home = '';
        $this->title = $title;
        $this->head = '';
        $this->body = '';
        $this->menu = '';
    }

    public function getHead(): string
    {
        return $this->head;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getMenu(): string
    {
        return $this->menu;
    }

    public function getHome(): string
    {
        return $this->home;
    }

    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    public function appendCss(string $css): void
    {
        $this->head .= <<<HTML
        <style>{$css}</style>
        HTML;
    }

    public function appendCssUrl(string $url): void
    {
        $this->head .= <<<HTML
        <link rel="stylesheet" href="{$url}">
        HTML;
    }

    public function appendJs(string $js): void
    {
        $this->head .= <<<HTML
        <script>{$js}</script>
        HTML;
    }

    public function appendJsUrl(string $url): void
    {
        $this->head .= <<<HTML
        <script src="{$url}"></script>
        HTML;
    }

    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    public function toHTML(): string
    {
        return <<<HTML
        <!doctype html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>{$this->title}</title>
            <style>#modif {text-align: end; font-style: italic; font-size: 14px; margin: 0;}</style>
            {$this->head}
        </head>
        <body>
            {$this->getBody()}
            <p id="modif">{$this->getLastModification()}</p>
        </body>
        </html>
        HTML;
    }

    public function getLastModification(): string
    {
        $date = date('d/m/Y', getlastmod());
        $heure = date('H:i:s', getlastmod());

        return 'Derniere modification : ' . $date . ' - ' . $heure;
    }

    public function appendToMenu(string $content): void
    {
        $this->menu .= $content;
    }

    public function appendMenuButton(string $texte, string $url): void
    {
        $this->menu .= "<a class='button' id='$texte' href='{$url}'>{$texte}</a>";
    }

    public function appendHomeButton(string $url): void
    {
        $this->home .= "<a class='homeButton' href='{$url}'><img src='../../public/img/home.png'></a>";
    }
}
