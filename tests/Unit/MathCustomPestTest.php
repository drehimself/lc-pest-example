<?php

use App\Models\MathCustom;

beforeEach(function () {
    $this->math = new MathCustom;
});

test('addition works', function () {
    $result = $this->math->add(1, 1);

    $this->assertEquals(2, $result);
    expect($result)->toBe(2);
});

test('addition works with datasets', function ($num1, $num2, $expected) {
    $result = $this->math->add($num1, $num2);

    $this->assertEquals($expected, $result);
})->with([
    [1, 1, 2],
    [2, 2, 4],
    [3, 5, 8],
]);

test('subtraction works', function () {
    $result = $this->math->subtract(5, 3);

    $this->assertEquals(2, $result);
});

test('multiplication works', function () {
    $result = $this->math->multiply(3, 2);

    $this->assertEquals(6, $result);
});
