<?php

declare(strict_types=1);
use Html\AppWebPage;
use Entity\Exception\EntityNotFoundException;
use Entity\Season;
use Entity\Collection\SeasonCollection;
use Entity\TVShow;

$appWebPage = new AppWebPage();

try {
    if(empty($_GET['showId']) || !is_numeric($_GET['showId'])) {
        header("Location: index.php");
        exit();
    }
    $tvshow = TVShow::findById((int)$_GET['showId']);
    $appWebPage->setTitle("Saisons de {$appWebPage->escapeString($tvshow->getName())}");
    $appWebPage->appendHomeButton();
    $appWebPage->appendMenuButton('Modifier', '/admin/show-form.php?showId='.$tvshow->getId());
    $appWebPage->appendMenuButton('Supprimer', '/admin/show-delete.php?showId='.$tvshow->getId());
    $originalName = "";
    if($tvshow->getOriginalName() != $tvshow->getName()) {
        $originalName = $tvshow->getOriginalName();
    }
    $appWebPage->appendContent(
        <<<HTML
            <div class="show">
                            <div class="showPoster">
                                <img src="poster.php?posterId={$tvshow->getPosterId()}" alt="{$tvshow->getName()}">
                            </div>
                            <div class="informations">
                                <div class="informationsContent">
                                    <div class="showTitle">
                                        {$tvshow->getName()}
                                    </div>
                                    <div class="showOriginalTitle">
                                        {$originalName}
                                    </div>
                                </div>
                                <div class="showDescription">
                                    {$tvshow->getOverview()}
                                </div>
                            </div>
                        </div>\n
        HTML
    );
    foreach (SeasonCollection::findByTVShowId((int)$_GET['showId']) as $season) {
        $appWebPage->appendContent(
            <<<HTML
                            <a href="season.php?seasonId={$season->getId()}">
                                <div class="season">
                                    <div class="seasonPoster">
                                        <img src="poster.php?posterId={$season->getPosterId()}" alt="{$season->getName()}">
                                    </div>
                                    <div class="seasonTitle">
                                        {$season->getName()}
                                    </div>
                                </div>
                            </a>\n
            HTML
        );
    }

    echo $appWebPage->toHtml();

} catch (EntityNotFoundException) {
    http_response_code(404);
    exit();
}
