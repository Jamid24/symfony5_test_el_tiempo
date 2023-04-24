<?php
declare(strict_types=1);

namespace App\tests\Unit\Controller\Api\v1;

class ProductApiV1ControllerTest extends \PHPUnit\Framework\TestCase
{
    /*
     * 
     * Test que valida la generación del JSON Web Token
     * con el fin de acceder a las API's de producto.
     * 
     * Se valida Codigo de respuesta de la petición (200)
     * y que exista la llave "token" en el json de la respuesta
     * del web service.
     * */        
    public function testGetToken(): void
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://localhost:8000',
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);
        $response = $client->get('/api/login_check', [
            'json' => [
                'username' => 'eltiempo_api',
                'password' => '$4HYvt2H'
            ]
        ]);
        //print_r(var_dump($response), true);
        //print_r(var_dump($response->getStatusCode()), true);
        $this->assertSame(200, $response->getStatusCode());
        $data = json_decode((string)$response->getBody(), true);
        //print_r(var_dump($data), true);
        $this->assertArrayHasKey('token', $data);
    }
}