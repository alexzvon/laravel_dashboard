<?php

namespace App\Jobs;

use App\Services\Catalog\CountSectionsCatalogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CountSectionCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CountSectionsCatalogService $countSectionsCatalogService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->countSectionsCatalogService = app(CountSectionsCatalogService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $result = $this->countSectionsCatalogService->countSections();

        if (is_array($result)) {
            Log::error((string)$result['error']);
        } else {
            Log::alert($result);
        }
    }
}
