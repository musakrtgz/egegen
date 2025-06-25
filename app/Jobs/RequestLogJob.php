<?php

namespace App\Jobs;

use App\Services\RequestLogService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RequestLogJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            RequestLogService::store($this->data);
        } catch (\Throwable $e) {
            dump("Error logging request: " . $e->getMessage());
        }
    }
}
