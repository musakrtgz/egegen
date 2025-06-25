<?php

namespace Database\Seeders;

use App\Jobs\NewsSeederJob;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 250000;
        $batchSize = 1000;

        // aynı anda tüm haber eklenemeyeceği için parçalara böldük ve kuyruğa gönderdik.
        for ($i = 0; $i < $total / $batchSize; $i++) {
            $news = News::factory()->count($batchSize)->make();
            NewsSeederJob::dispatch($news->toArray());
            $this->command->info("✔ " . $i . "/" . $total / $batchSize . " haber başarıyla eklendi.");
        }
        $this->command->info("✔ Tüm haberler başarıyla eklendi.");
    }
}
