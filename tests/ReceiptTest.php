<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
    public function setUp(){  //lisame meetodi setUp
        $this->Receipt = new Receipt(); // loome receipt objekti, mis on võrdne uue receipt objektiga
    }

    public function tearDown(){  //lisame meetodi tearDown, see tühistab receipt objekti, tagades, et PHP ei kannaks midagi ühest testikäigust teise.
        unset($this->Receipt); //
    }

    /**
     * @dataProvider provideTotal // dataProvideri abil saame testida erinevaid väärtuseid, ilma et peaksime koodi mitu korda dubleerima
     */

    public function testTotal($items, $expected){
//        $input = [0, 2, 5, 8]; // antud arvud, mis liidetakse kokku
        $coupon = null; // lisame testTotalile kupongi, mis on võrdne nullile, millest test ei hooli, kui terminalis testid jooksma pannakse
        $output = $this->Receipt->total($items, $coupon); // output on siis võrdne selle arve summaga. See muudab testi rohkem isoleeritumaks
        $this->assertEquals(
//            15, // eeldatakse, et arve summa on 15
            $expected, // oodatavad tulemused, mis tuleb provideTotal funktsioonist
            $output, // väljastab summa
            "When summing the total should equal {$expected}"  // väljasab sõnumi, kui test kukub läbi
        );

    }

    public function provideTotal() { // siin on erinevad väärtused, mida testTotal test hakkab läbi viima, ehk
        //  kui üks nendest failib, visatakse error, mis ütleb, milline output peaks olema.
        return [
            'ints totaling 16' => [[1,2,5,8], 16],
            [[-1,2,5,8], 14],
            [[1,2,8], 11],
        ];
    }

    public function testTotalAndCoupon() {
        $input = [0,2,5,8];
        $coupon = 0.20;
        $output = $this->Receipt->total($input, $coupon);
        $this->assertEquals(
            12, // kui kupong on arvutatud, siis tvastus peaks olema 12, mitte 15
            $output,
            'When summing the total should equal 12'
        );
    }

    public function testPostTaxTotal() { // lisame uue funktsiooni, sellega ehitame mock PHPUniti
        $items = [1,2,5,8]; // lisame väärtused, mis muutab stubi mockiks
        $tax = 0.20;
        $coupon = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')  //ja me ehitame Receipt klassist
            ->setMethods(['tax', 'total']) // ta võtab need kaks meetodit, mis vastavad totalile ja tax'le
            ->getMock();

        $Receipt->expects($this->once())
            ->method('total')
            ->with($items, $coupon)
            ->will($this->returnValue(10.00));

//        $Receipt->method('total')
//            ->will($this->returnValue(10.00)); // annavad vajalikud andmed

        $Receipt->expects($this->once()) // kutsub koodi välja ainult ühe korra, see kas kutsub mingi arvu ühe korra või ei kutsugi.
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));

//        $Receipt->method('tax')
//            ->will($this->returnValue(1.00)); // annavad vajalikud andmed

        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);  // võtame väärtused
        $this->assertEquals(11.00, $result); // ning loodame, et oodatud vastus on 11.00
    }

    public function testTax() { // loome uue meetodi
        $inputAmount = 10.00; //loome sisendi, mis on 10 rahaühikut
        $taxInput = 0.10; // see on maksu %
        $output = $this->Receipt->tax($inputAmount, $taxInput); // kutsume selle meetodi Receipt objektis välja, mis korrutab parameetrid.
        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }
}


// Kui teste on mitu, mis tähendab, et terminal ei jooksuta neid kiiresti läbi. Seega on vaja terminali
//hoopis kirjutada $vendor\bin\phpunit tests\ ja ss täpsustada faili ehk ReceiptTest.php, mmis peaks võtma
//ainult testid, mis on selles failis

// test on nüüd mock ning terminalis on näha, et failis on neli testi ning 5 väidet, ehk mock on uus väide
// ning nende andmed peavad olema õiged, kui mockis on viga, siis test feilib

// kui me tahame veel täpsemalt, siis me saame testi filtreerida selle võtmega, kirjutame terminali sisse vendor\bin\phpunit --filter
// ning me saame selle võrduma panna näiteks testTotal või number 1-ga, mis võtab siis ainult valitud testi ning jooksutab seda.
