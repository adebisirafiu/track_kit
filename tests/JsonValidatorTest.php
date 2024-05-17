<?php
use PHPUnit\Framework\TestCase;
use App\JsonValidator;

class JsonValidatorTest extends TestCase {
    public function testValidJson() {
        $jsonString = '{"data":{"message":"Unauthorized"}}';
        $expected = ['data' => ['message' => 'Unauthorized']];
        $this->assertEquals($expected, JsonValidator::validateAndConvert($jsonString));
    }

    public function testInvalidJson() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid JSON');
        $jsonString = '{"data":{"message":"Unauthorized"';
        JsonValidator::validateAndConvert($jsonString);
    }

    public function testMissingDataKey() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing "data" key in JSON data');
        $jsonString = '{"error":"Unauthorized"}';
        JsonValidator::validateAndConvert($jsonString);
    }
}
