<?php

test('returns ok on health endpoint', function () {
    $response = $this->get('/api/v1/health');

    $response->assertStatus(200);
    $response->assertJson(['data' => ['status' => 'OK', 'app' => 'MovieAPI'],
        'message' => 'Health check']);
});
