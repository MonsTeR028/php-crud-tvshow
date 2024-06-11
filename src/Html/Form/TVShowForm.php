<?php

namespace Html\Form;

use Entity\Exception\ParameterException;
use Entity\TVShow;
use Html\StringEscaper;

class TVShowForm
{
    use StringEscaper;

    private ?TVShow $show;

    public function __construct(?TVShow $show = null)
    {
        $this->show = $show;
    }

    public function getTVShow(): ?TVShow
    {
        return $this->show;
    }

    public function getHtmlForm(string $action): string
    {
        return <<<HTML
            <form method="post" action="{$action}">
                <input name="id" type="hidden" value="{$this->show?->getId()}" hidden>
                <label>
                    Nom de la série :
                    <input name="name" type="text" value="{$this->escapeString($this->show?->getName())}" required>
                </label>
                <label>
                    Nom original :
                    <input name="originalName" type="text" value="{$this->escapeString($this->show?->getOriginalName())}" required>
                </label>
                <label>
                    Lien vers la série :
                    <input name="homepage" type="url" value="{$this->show?->getHomepage()}" required>
                </label>
                <label>
                    Description :
                    <input name="overview" type="text" value="{$this->escapeString($this->show?->getOverview())}" required>
                </label>
                <button type="submit">Enregistrer</button>
            </form>
        HTML;
    }

    /**
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {
        $id = null;
        if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
            $id = (int) $_POST['id'];
        }
        if (!empty($_POST['name']) && !empty($_POST['originalName']) && !empty($_POST['homepage']) && !empty($_POST['overview'])) {
            $name = $this->stripTagsAndTrim($_POST['name']);
            $originalName = $this->stripTagsAndTrim($_POST['originalName']);
            $homepage = $_POST['homepage'];
            $overview = $this->stripTagsAndTrim($_POST['overview']);
        } else {
            throw new ParameterException("TVShowForm - setEntityFromQueryString : Paramètre(s) invalide(s)");
        }
        $this->show = TVShow::create($name, $originalName, $homepage, $overview, $id);
    }
}
