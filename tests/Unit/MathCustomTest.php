<?php

namespace Tests\Unit;

use App\Models\MathCustom;
use PHPUnit\Framework\TestCase;

class MathCustomTest extends TestCase
{
    public function setUp() : void
    {
        $this->math = new MathCustom;
    }

    /** @test */
    public function addition_works()
    {
        $result = $this->math->add(1, 1);

        $this->assertEquals(2, $result);
    }

    /**
     * @test
     * @dataProvider additionProvider
     */
    public function addtion_works_data_provider($num1, $num2, $expected)
    {
        $result = $this->math->add($num1, $num2);
        $this->assertEquals($expected, $result);
    }

    public function additionProvider()
    {
        return [
            [1, 1, 2],
            [2, 2, 4],
            [3, 2, 5],
            [5, 5, 10],
        ];
    }

    /** @test */
    public function subtraction_works()
    {
        $result = $this->math->subtract(5, 3);

        $this->assertEquals(2, $result);
    }

    /** @test */
    public function multiplication_works()
    {
        $result = $this->math->multiply(3, 2);

        $this->assertEquals(6, $result);
    }
}
