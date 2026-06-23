<?php

test('returns ok on health endpoint', function () {
    $response = $this->get('/api/health');

    $response->assertStatus(200);
    $response->assertJson(["data" =>["status"=>"OK", "app"=>"MovieAPI"],
                                  "message" => "Health check"]);
});