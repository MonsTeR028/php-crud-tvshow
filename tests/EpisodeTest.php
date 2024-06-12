<?php

use PHPUnit\Framework\TestCase;
use Entity\Episode;

class EpisodeTest extends TestCase
{
    public function testSettersAndGetters()
    {
        $episode = new Episode();

        $episode->setId(1);
        $this->assertSame(1, $episode->getId());

        $episode->setSeasonId(2);
        $this->assertSame(2, $episode->getSeasonId());

        $episode->setEpisodeNumber(3);
        $this->assertSame(3, $episode->getEpisodeNumber());

        $episode->setOverview("This is an overview.");
        $this->assertSame("This is an overview.", $episode->getOverview());

        $episode->setName("Episode Name");
        $this->assertSame("Episode Name", $episode->getName());
    }
}
