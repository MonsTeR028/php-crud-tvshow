<?php

namespace Html\Form;

use Entity\TVShow;
use Html\StringEscaper;

class TVShowForm
{
    use StringEscaper;

    private ?TVShow $show;

    public function __construct(?TVShow $show = null)
    {
        $this->show = $show;
    }

    public function getTVShow(): ?TVShow
    {
        return $this->show;
    }
}