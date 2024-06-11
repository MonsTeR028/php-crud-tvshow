<?php

declare(strict_types=1);
use Html\AppWebPage;
use Entity\Exception\EntityNotFoundException;
use Entity\Season;
use Entity\TVShow;
use Entity\Collection\EpisodeCollection;

$appWebPage = new AppWebPage();

try {
    if(empty($_GET['seasonId']) || !is_numeric($_GET['seasonId'])) {
        header("Location: index.php");
        exit();
    }
    $season = Season::findById((int)$_GET['seasonId']);
    $appWebPage->setTitle("Episodes de {$appWebPage->escapeString($season->getName())}");
    $tvShow = TvShow::findById($season->getTvShowId());
    $appWebPage->appendContent(
        <<<HTML
<div class="season">
        <div class="seasonPoster">
            <img src="poster.php?posterId={$season->getPosterId()}" alt="{$season->getName()}">
        </div>
        <div class="seasonInformations">
            <div class="showTitle"><a href="{$tvShow->getHomepage()}">{$tvShow->getName()}</a></div>
            <div class="seasonTitle">{$season->getName()}</div>
        </div>
</div>
HTML
    );
    foreach (EpisodeCollection::findBySeasonId((int)$_GET['seasonId']) as $episode) {
        $appWebPage->appendContent(
            <<<HTML
<div class="episode">
        <div class="episodeNumber">
            {$episode->getEpisodeNumber()} - {$episode->getName()}
        </div>
        <div class="episodeDescription">
            {$episode->getOverview()}
        </div>
</div>
HTML
        );
    }

    echo $appWebPage->toHtml();

} catch (EntityNotFoundException) {
    http_response_code(404);
    exit();
}
