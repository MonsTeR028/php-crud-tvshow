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
    $webPage->appendToHead("<meta name='description' content='Formulaire pour une série'>");
    $webPage->appendHomeButton();
    $webPage->appendCssUrl('css/form.css');
    $showForm = new TvShowForm($show);
    $webPage->appendContent(
        <<<HTML
<div class="form">
    {$showForm->getHtmlForm('show-save.php')}   
</div>
HTML
    );
    echo $webPage->toHtml();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
