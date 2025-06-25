<?php

namespace Tests\Feature;

use Tests\TestCase;

class NewsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_it_fails_without_token(): void
    {
        $this->artisan('migrate');

        $response = $this->getJson('/api/news');

        // token olmadığı için 401 beklenir
        $response->assertStatus(401);
    }

    /** @test */
    public function it_lists_news_with_valid_token()
    {
        // 5 adet haber oluşturur
        \App\Models\News::factory()->count(5)->create();

        $response = $this->getJson('/api/news', [
            'Authorization' => 'Bearer ' . config('auth.bearer_token'),
        ]);

        $response->assertStatus(200);

        // data dizisi geldi mi?
        $response->assertJsonStructure([
            'data', // haberler dizisi
            'meta', // sayfalama varsa
            'links', // sayfalama linkleri varsa
        ]);

        // json’da en az 5 haber var mı?
        $this->assertGreaterThanOrEqual(5, count($response->json('data')));
    }
}
