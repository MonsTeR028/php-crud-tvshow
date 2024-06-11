<?php


declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Html\Form\TVShowForm;
use Html\WebPage;
use Entity\TVShow;

try {
    $show = null;
    if(isset($_GET['showId'])) {
        if(!ctype_digit($_GET['showId'])) {
            throw new ParameterException("L'id n'est pas un entier");
        }
        $show = TVShow::findById((int)$_GET['showId']);
    }
    //Création du formulaire
    $webPage = new WebPage("Formulaire série");
    $showForm = new TvShowForm($show);
    $webPage->appendContent($showForm->getHtmlForm('show-save.php'));
    echo $webPage->toHtml();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
