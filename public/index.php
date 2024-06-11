<?php

use Entity\Collection\TVShowCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Séries TV");
$webPage->appendMenuButton('Ajouter', '/admin/show-form.php');
$rech = empty($_GET['recherche']) ? null : $_GET['recherche'];
$webPage->appendContent(
    <<<HTML
        <form class="recherche-show" method="get" action="index.php">
            <label>
                Recherche :
                <input name="recherche" type="text" value="$rech">
                <button type="submit">Envoyer</button>
            </label>
        </form>
    HTML
);

if (!empty($_GET['recherche'])) {
    $listeShow = TVShowCollection::findTVShowByResearch($_GET['recherche']);
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
</a>
HTML
    );
}

echo $webPage->toHTML();
