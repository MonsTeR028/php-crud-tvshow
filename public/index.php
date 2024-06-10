<?php

use Entity\Collection\TVShowCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Séries TV");
foreach (TVShowCollection::findAll() as $tvShow) {
    $webPage->appendContent(
        <<<HTML
<div class="show">
<div class="showPoser">
<img src="poster.php?posterId={$tvShow->getPosterId()}" alt="{$tvShow->getName()}">
</div>
<div class="showTitle">
{$tvShow->getName()}
</div>
<div class="showDescription">
{$tvShow->getOverview()}
</div>
</div>
HTML
    );
}

echo $webPage->toHTML();
