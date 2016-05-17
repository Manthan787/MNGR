<?php

class QuestionTest extends TestCase {

    public function setUp() {
      parent::setUp();
      Route::enableFilters();
    }

    public function testAccessWithoutLogin() {
      Auth::logout();
      $response = $this->call('GET', 'http://localhost:8000/api/Questions/all');
      $data = $this->parseJson($response);
      $this->assertEquals('You need to login to access this page!', $data->msg);
    }

    public function testAccessWithLogin() {
        $user = User::find(1);
        Auth::login($user);

        $response = $this->call('GET', 'http://localhost:8000/api/Questions/all');
        $data = $this->parseJson($response);
        $this->assertInternalType('array', $data);
    }

}
?>
