<?php

use Entity\Collection\TVShowCollection;
use Html\AppWebPage;
use Entity\Genre;
use Entity\Collection\GenreCollection;
use Entity\TVShow;

$webPage = new AppWebPage("Séries TV");
$webPage->appendMenuButton('Ajouter', '/admin/show-form.php');
$rech = empty($_GET['recherche']) ? null : $_GET['recherche'];

$genreSelector = <<<HTML
<label for="genre-select">
                            Choisir un genre :
                            <select name="genre" id="genre-select">
                                <option value="0" hidden></option>\n
HTML;

foreach (GenreCollection::findAll() as $genre) {
    if(isset($_GET['genre']) && $genre->getId() == (int)$_GET['genre']) {
        $genreSelector .= <<<HTML
                                <option value="{$genre->getId()}" selected>{$genre->getName()}</option>\n
HTML;
    } else {
        $genreSelector .= <<<HTML
                                <option value="{$genre->getId()}">{$genre->getName()}</option>\n
HTML;
    }
}

$genreSelector .= <<<HTML
                            </select>
                        </label>
HTML;

$webPage->appendContent(
    <<<HTML
        <div class="filters">
                        <form class="recherche-show" method="get" action="index.php">
                            <label>
                                Recherche :
                                <input name="recherche" type="text" value="$rech">
                            </label>
                            <button type="submit">Envoyer</button>
                        </form>
                        <form class="recherche-show" method="get" action="index.php">
                            {$genreSelector}
                            <button type="submit">Envoyer</button>
                        </form>
                        <a href="index.php">Réinitialiser les filtres</a>
                    </div>\n
    HTML
);

if (!empty($_GET['recherche'])) {
    $listeShow = TVShowCollection::findTVShowByResearch($_GET['recherche']);
} elseif(!empty($_GET['genre'])) {
    $listeShow = TVShowCollection::findByGenreId((int)$_GET['genre']);
} else {
    $listeShow = TVShowCollection::findAll();
}

foreach ($listeShow as $tvShow) {
    $webPage->appendContent(
        <<<HTML
                        <a href="show.php?showId={$tvShow->getId()}">
                            <div class="show">
                                <div class="showPoster">
                                    <img src="poster.php?posterId={$tvShow->getPosterId()}" alt="{$tvShow->getName()}">
                                </div>
                                <div class="informations">
                                    <div class="showTitle">
                                        {$tvShow->getName()}
                                    </div>
                                    <div class="showDescription">
                                        {$tvShow->getOverview()}
                                    </div>
                                </div>
                            </div>
                        </a>\n
        HTML
    );
}

echo $webPage->toHTML();
