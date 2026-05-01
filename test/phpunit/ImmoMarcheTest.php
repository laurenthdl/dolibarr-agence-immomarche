<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../../class/immomarche.class.php';

use PHPUnit\Framework\TestCase;

class ImmoMarcheTest extends TestCase
{
    /** @test */
    public function venteCompClassShouldExist(): void
    {
        $this->assertTrue(class_exists('ImmoVenteComp'));
    }

    /** @test */
    public function venteCompShouldCalculatePricePerSquareMeterCorrectly(): void
    {
        $db = new DoliDB();
        $vente = new ImmoVenteComp($db);
        $vente->prix_vente = 300000.0;
        $vente->surface = 100.0;

        $this->assertSame(3000.0, $vente->calculPrixAuM2());
    }

    /** @test */
    public function locationCompShouldCalculateRentPerSquareMeterCorrectly(): void
    {
        $db = new DoliDB();
        $location = new ImmoLocationComp($db);
        $location->loyer_mensuel = 1200.0;
        $location->surface = 60.0;

        $this->assertSame(20.0, $location->calculPrixAuM2());
    }

    /** @test */
    public function venteNumRefShouldMatchFormat(): void
    {
        $db = new DoliDB();
        $vente = new ImmoVenteComp($db);

        $this->assertMatchesRegularExpression('/^MBV-\d{4}-\d{4}$/', $vente->getNextNumRef());
    }

    /** @test */
    public function locationNumRefShouldMatchFormat(): void
    {
        $db = new DoliDB();
        $location = new ImmoLocationComp($db);

        $this->assertMatchesRegularExpression('/^MBL-\d{4}-\d{4}$/', $location->getNextNumRef());
    }
}
