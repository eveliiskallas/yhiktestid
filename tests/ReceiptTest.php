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

    public function testTotal(){
        $input = [0, 2, 5, 8]; // antud arvud, mis liidetakse kokku
        $output = $this->Receipt->total($input); // output on siis võrdne selle arve summaga. See muudab testi rohkem isoleeritumaks
        $this->assertEquals(
            15, // eeldatakse, et arve summa on 15
            $output, // väljastab summa
            'When summing the total should equal 15' // väljastab sõnumi, kui test kukub läbi
        );

    }

    public function testTax() // loome uue meetodi
    {
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
