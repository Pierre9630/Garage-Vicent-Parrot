<?php
use Liip\FunctionalTestBundle\Test\WebTestCase;

class FixturesTest extends WebTestCase
{
        public function setUp(): void
        {
            $this->loadFixtures([
            \App\DataFixtures\CarFixtures::class,
        ]);
    }
}
