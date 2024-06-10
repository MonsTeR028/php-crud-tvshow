<?php

use Entity\Collection\TVShowCollection;
use Html\WebPage;

$webPage = new WebPage("Séries TV");
$webPage->appendContent("<h1>Série TV</h1>");
foreach (TVShowCollection::findAll() as $tvShow) {
    $webPage->appendContent(
        <<<HTML
<div class="show">
<div class="showPoser">
<img src="" alt="">
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
