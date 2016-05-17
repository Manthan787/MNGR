<?php
use Auth;
use GuzzleHttp\Client;
class QuestionTest extends TestCase {

    public function setUp() {
      parent::setUp();
      Auth::loginUsingId(1);
    }

    public function testAccessWithoutLogin() {
      $client = new Client();
      try {
        $response = $client->request('GET', 'http://localhost:8000/api/Questions/all');
      }
      catch(GuzzleHttp\Exception\ClientException $e) {
        $this->assertEquals(401, $e->getResponse()->getStatusCode());
      }

    }

}
?>
