<?php

namespace Tests\Feature\API\v1;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;

class BestSellersTest extends TestCase
{
    #[Test]
    public function it_should_fail_validation_if_offset_is_invalid(): void
    {

        Http::fake();

        // The offset must be a multiple of 20 or 0!
        $response = $this->getJson('/api/1/nyt/best-sellers?offset=31');
        $response->assertStatus(422);

        // The offset cannot be a string value!
        $response = $this->getJson('/api/1/nyt/best-sellers?offset=thisAintNoNumber');
        $response->assertStatus(422);

        Http::assertNothingSent();
    }

    #[Test]
    public function it_should_fail_validation_if_isbns_are_of_invalid_length(): void
    {

        Http::fake();

        // ISBN lengths must be either 10 or 13 characters long!
        $response = $this->getJson('/api/1/nyt/best-sellers?isbn[]=01234567892');
        $response->assertStatus(422);

        $response = $this->getJson('/api/1/nyt/best-sellers?isbn[]=0123456789&isbn[]=0');
        $response->assertStatus(422);

        Http::assertNothingSent();
    }

}
