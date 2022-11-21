<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ServerTimeEndpointTest extends TestCase
{

    use RefreshDatabase, withFaker;

    /**
     * A basic integration test for server time endpoint.
     *
     * Could be more detailed if all migrations were created.
     *
     * @group endpoint_fetches_server_time
     *
     * @return void
     * @throws \Exception
     */
    public function test_endpoint_fetches_server_time()
    {

        /**
         * @given there is one user saved in DB
         */
        $user = User::factory()->createOne();

        /**
         * @given user is authenticated
         */
        $this->be($user, 'api');

        $response = $this->get('/api/servertime/?api-key=sampleapikey');

        $response->assertStatus(200)->assertJsonStructure([
            'serverTime',
        ]);
    }
}
