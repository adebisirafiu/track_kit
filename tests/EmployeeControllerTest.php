<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\EmployeeController;
use App\Request;

class EmployeeControllerTest extends TestCase {
    public function testHandleProvider1() {
        $controller = $this->getMockBuilder(EmployeeController::class)
                           ->onlyMethods(['sendToTrackTikApi'])
                           ->getMock();
        
        $controller->expects($this->once())
                   ->method('sendToTrackTikApi')
                   ->with([
                       'first_name' => 'John',
                       'last_name' => 'Doe',
                       'email' => 'john.doe@example.com'
                   ]);

        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $request->method('getData')
                ->willReturn('{"data":{"first_name":"John","last_name":"Doe","email":"john.doe@example.com"}}');

        $controller->handleProvider1($request);
    }

    public function testHandleProvider2() {
        $controller = $this->getMockBuilder(EmployeeController::class)
                           ->onlyMethods(['sendToTrackTikApi'])
                           ->getMock();
        
        $controller->expects($this->once())
                   ->method('sendToTrackTikApi')
                   ->with([
                       'first_name' => 'Jane',
                       'last_name' => 'Smith',
                       'email' => 'jane.smith@example.com'
                   ]);

        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $request->method('getData')
                ->willReturn('{"data":{"givenName":"Jane","surname":"Smith","contactEmail":"jane.smith@example.com"}}');

        $controller->handleProvider2($request);
    }

    public function testHandleProvider1WithInvalidJson() {
        $controller = new EmployeeController();

        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $request->method('getData')
                ->willReturn('{"data":{invalid json}}');

        ob_start();
        $controller->handleProvider1($request);
        $output = ob_get_clean();

        $this->assertEquals(400, http_response_code());
        $this->assertStringContainsString('Invalid JSON', $output);
    }

    public function testHandleProvider1WithMissingDataKey() {
        $controller = new EmployeeController();

        $request = $this->getMockBuilder(Request::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $request->method('getData')
                ->willReturn('{"message":"Unauthorized"}');

        ob_start();
        $controller->handleProvider1($request);
        $output = ob_get_clean();

        $this->assertEquals(400, http_response_code());
        $this->assertStringContainsString('Missing "data" key in JSON data', $output);
    }
}
