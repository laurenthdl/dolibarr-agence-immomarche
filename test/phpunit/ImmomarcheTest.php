<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../../class/immo_marche_comparable.class.php';
class ImmomarcheTest extends PHPUnit\Framework\TestCase {
    /** @test */ public function classShouldExist(): void { $this->assertTrue(class_exists('ImmomarcheObject')); }
    /** @test */ public function uiFilesShouldExist(): void { $this->assertFileExists(__DIR__ . '/../../index.php'); $this->assertFileExists(__DIR__ . '/../../card.php'); }
}
