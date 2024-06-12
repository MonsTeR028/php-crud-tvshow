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

    /**
     * Permet d'ajouter du contenu à la balise <head>
     * @param string $content : le contenu à ajouter
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Permet d'ajouter du css à la page
     * @param string $css : le css à ajouter
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->head .= <<<HTML
        <style>{$css}</style>
        HTML;
    }

    /**
     * Permet d'ajouter un lien vers une feuille de style css
     * @param string $url : lien de la feuille de style
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->head .= <<<HTML
        <link rel="stylesheet" href="{$url}">
        HTML;
    }

    /**
     * Permet d'ajouter du javascript à la page
     * @param string $js : script à ajouter
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->head .= <<<HTML
        <script>{$js}</script>
        HTML;
    }

    /**
     * Permet d'ajouter un lien vers un script JavaScript
     * @param string $url : le lien du script JavaScript
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->head .= <<<HTML
        <script src="{$url}"></script>
        HTML;
    }

    /**
     * Permet d'ajouter du contenu à la balise <body> de la page
     * @param string $content : le contenu à ajouter
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Permet de créer la page html
     * @return string : la page html
     */
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
            {$this->home}
            {$this->body}
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

    public function appendHomeButton(): void
    {
        $this->home .= "<a class='homeButton' href='/index.php'><img src='/img/home.png'></a>";
    }
}
