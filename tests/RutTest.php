<?php

use JuanStiza\Rut\Rut;

class RutTest extends PHPUnit_Framework_TestCase{

    public function testDigitoVerificador()
    {
        $dv = Rut::findDV(1234);
        $this->assertTrue($dv == '3');
    }

    public function testCreateRutInstance()
    {
        $rut = new Rut(24232771,3);
        $this->assertTrue($rut->rut == 24232771);
        $this->assertTrue($rut->dv == 3);
        $rut = new Rut('242327713');
        $this->assertTrue($rut->rut == 24232771);
        $this->assertTrue($rut->dv == 3);
        $rut = new Rut('24232771-3');
        $this->assertTrue($rut->rut == 24232771);
        $this->assertTrue($rut->dv == 3);
    }

    public function testIfValidIsTrue()
    {
        $rut = new Rut(24232771,3);
        $this->assertTrue($rut->isValid);
        $rut = new Rut(242327713);
        $this->assertTrue($rut->isValid);
        $rut = new Rut('242327713');
        $this->assertTrue($rut->isValid);
    }

    public function testIfValidIsFalse()
    {
        $rut = new Rut(11111112,1);
        $this->assertFalse($rut->isValid);
        $rut = new Rut(111111121);
        $this->assertFalse($rut->isValid);
        $rut = new Rut('111111121');
        $this->assertFalse($rut->isValid);
    }

    public function testFormats()
    {

        $rut = new Rut('12.53213-k');
        $this->assertTrue($rut->rut == 1253213);
        $this->assertTrue($rut->dv == 'k');

        $rut = new Rut('1253213k');
        $this->assertTrue($rut->rut == 1253213);
        $this->assertTrue($rut->dv == 'k');

        $rut = new Rut('3k');
        $this->assertTrue($rut->rut == 3);
        $this->assertTrue($rut->dv == 'k');

        $this->setExpectedException('Exception','Rut has wrong length.');
        $rut = new Rut('3');

    }

}
