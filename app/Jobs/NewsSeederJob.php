<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class NewsSeederJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $items = [])
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // hızlı şekilde ve toplu ekleme yapabilmek için DB facade insert kullanıyoruz.
        DB::table('news')->insert($this->items);
    }
}
