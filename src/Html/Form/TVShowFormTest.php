<?php

use PHPUnit\Framework\TestCase;
use Entity\TVShow;
use Html\Form\TVShowForm;
use Entity\Exception\ParameterException;

class TVShowFormTest extends TestCase
{
    public function testGetHtmlFormWithShow()
    {
        $tvShow = TVShow::create('Test Show', 'Test Original', 'http://test.com', 'A test overview', 1);
        $form = new TVShowForm($tvShow);

        $html = $form->getHtmlForm('submit.php');
        $this->assertStringContainsString('<form method="post" action="submit.php">', $html);
        $this->assertStringContainsString('<input name="id" type="hidden" value="1" hidden>', $html);
        $this->assertStringContainsString('<input name="name" type="text" value="Test Show" required>', $html);
        $this->assertStringContainsString('<input name="originalName" type="text" value="Test Original" required>', $html);
        $this->assertStringContainsString('<input name="homepage" type="url" value="http://test.com" required>', $html);
        $this->assertStringContainsString('<input name="overview" type="text" value="A test overview" required>', $html);
        $this->assertStringContainsString('<button type="submit">Enregistrer</button>', $html);
    }

    public function testGetHtmlFormWithoutShow()
    {
        $form = new TVShowForm();

        $html = $form->getHtmlForm('submit.php');
        $this->assertStringContainsString('<form method="post" action="submit.php">', $html);
        $this->assertStringContainsString('<input name="id" type="hidden" value="" hidden>', $html);
        $this->assertStringContainsString('<input name="name" type="text" value="" required>', $html);
        $this->assertStringContainsString('<input name="originalName" type="text" value="" required>', $html);
        $this->assertStringContainsString('<input name="homepage" type="url" value="" required>', $html);
        $this->assertStringContainsString('<input name="overview" type="text" value="" required>', $html);
        $this->assertStringContainsString('<button type="submit">Enregistrer</button>', $html);
    }

    public function testSetEntityFromQueryStringValidData()
    {
        $_POST = [
            'id' => '1',
            'name' => 'Test Show',
            'originalName' => 'Test Original',
            'homepage' => 'http://test.com',
            'overview' => 'A test overview'
        ];

        $form = new TVShowForm();
        $form->setEntityFromQueryString();

        $tvShow = $form->getTVShow();
        $this->assertInstanceOf(TVShow::class, $tvShow);
        $this->assertSame(1, $tvShow->getId());
        $this->assertSame('Test Show', $tvShow->getName());
        $this->assertSame('Test Original', $tvShow->getOriginalName());
        $this->assertSame('http://test.com', $tvShow->getHomepage());
        $this->assertSame('A test overview', $tvShow->getOverview());
    }

    public function testSetEntityFromQueryStringInvalidData()
    {
        $_POST = [
            'id' => '1',
            'name' => '',
            'originalName' => '',
            'homepage' => '',
            'overview' => ''
        ];

        $this->expectException(ParameterException::class);
        $this->expectExceptionMessage("TVShowForm - setEntityFromQueryString : Paramètre(s) invalide(s)");

        $form = new TVShowForm();
        $form->setEntityFromQueryString();
    }
}
