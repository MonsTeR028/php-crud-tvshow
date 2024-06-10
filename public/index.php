<?php

use Entity\Collection\TVShowCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Séries TV");
foreach (TVShowCollection::findAll() as $tvShow) {
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
