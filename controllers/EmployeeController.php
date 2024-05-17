<?php
namespace App\Controllers;

use App\JsonValidator;

class EmployeeController {
    public function handleProvider1($request) {
        try {
            $data = JsonValidator::validateAndConvert($request->getData());
            $mapped_data = $this->mapProvider1ToTrackTikSchema($data['data']);
            $this->sendToTrackTikApi($mapped_data);
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

    public function handleProvider2($request) {
        try {
            $data = JsonValidator::validateAndConvert($request->getData());
            $mapped_data = $this->mapProvider2ToTrackTikSchema($data['data']);
            $this->sendToTrackTikApi($mapped_data);
        } catch (\Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

    private function mapProvider1ToTrackTikSchema($data) {
        return [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ];
    }

    private function mapProvider2ToTrackTikSchema($data) {
        return [
            'first_name' => $data['givenName'],
            'last_name' => $data['surname'],
            'email' => $data['contactEmail'],
        ];
    }

    private function sendToTrackTikApi($data) {
        $url = 'https://smoke.staffr.net/rest/v1/employees';
        $headers = [
            'Authorization: Bearer YOUR_ACCESS_TOKEN',
            'Content-Type: application/json',
        ];
        $data_json = json_encode($data);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $formattedMsg = json_decode($response, true);
        
        if ($response === false) {
            http_response_code(500);
            echo "Error sending data to TrackTik";
        } else {
            if ($formattedMsg['message'] == 'Unauthorized') {
                http_response_code(401);
                echo "Unauthorized";
            }else{
                http_response_code(200);
                echo "Data sent to TrackTik successfully";
            }
        }
    }
}
