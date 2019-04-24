<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';
use PHPUnit\Framework\TestCase;
use TDD\Receipt;
class ReceiptTest extends TestCase {
    public function testTotal() {
        $Receipt = new Receipt(); //Luuakse objekt 'Receipt'

        $this->assertEquals(
            15, //Arve eeldatav summa peaks olema 15.

            $Receipt->total([0,2,5,8]), // Kui antud arvude summa (0,2,5,8) võrdub 15, siis test on sooritatud.
            // Kui eeldatava summa või antud arvud muudetakse ja selle summa on suurem või väiksem 15'st,
            // siis test kukub läbi.
            'When summing the total should equal 15'
        );
    }
}


