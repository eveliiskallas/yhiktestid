<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';
use PHPUnit\Framework\TestCase;
use TDD\Receipt;
class ReceiptTest extends TestCase {
    public function setUp() {  //lisame meetodi setUp
        $this->Receipt = new Receipt(); // loome receipt objekti, mis on võrdne uue receipt objektiga
    }
    public function tearDown() {  //lisame meetodi tearDown, see tühistab receipt objekti, tagades, et PHP ei kannaks midagi ühest testikäigust teise.
        unset($this->Receipt); //
    }
    public function testTotal() {
        $input = [0,2,5,9]; // antud arvud, mis liidetakse kokku
        $output = $this->Receipt->total($input); // output on siis võrdne selle arve summaga. See muudab testi rohkem isoleeritumaks
        $this->assertEquals(
            15, // eeldatakse, et arve summa on 15
            $output, // väljastab summa
            'When summing the total should equal 15' // väljastab sõnumi, kui test kukub läbi
        );
    }
}
