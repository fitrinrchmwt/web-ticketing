<?php

namespace App\Jobs;

use App\Models\DataPelanggan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SyncCustomersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 360;
    public int $tries   = 3;

    private string $endpoint = 'http://202.169.224.27:3004/api/v1/apps/customerpackages';

    public function handle(): void
    {
        $jobId = $this->job?->getJobId() ?? uniqid('job_', true);
        $start = microtime(true);

        Log::info('[SyncCustomersJob] START', [
            'job_id'   => $jobId,
            'endpoint' => $this->endpoint,
        ]);

        try {
            $response = Http::timeout(300)
                ->connectTimeout(15)
                ->get($this->endpoint);

            if (! $response->successful()) {
                Log::error('[SyncCustomersJob] API FAILED', [
                    'job_id' => $jobId,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return;
            }

            $customers = $response->json('data') ?? [];
            $total     = count($customers);

            Log::info('[SyncCustomersJob] API SUCCESS', [
                'job_id' => $jobId,
                'total'  => $total,
            ]);

            $success = 0;
            $failed  = 0;

            foreach ($customers as $index => $item) {
                try {
                    DataPelanggan::updateOrCreate(
                        ['custNumber' => $item['custNumber']],
                        [
                            'custName'        => $item['custName'] ?? null,
                            'custAddress'     => $item['custAddress'] ?? null,
                            'custPhone'       => $item['custPhone'] ?? null,
                            'custEmail'       => $item['custEmail'] ?? null,
                            'custGroupId'     => $item['custGroupId'] ?? null,
                            'custProvince'    => $item['custProvince'] ?? null,
                            'custDistrict'    => $item['custDistrict'] ?? null,
                            'custSubDistrict' => $item['custSubDistrict'] ?? null,
                            'custVillage'     => $item['custVillage'] ?? null,
                            'spCodeId'        => $item['spCodeId'] ?? null,
                            'spCode'          => $item['spCode'] ?? null,
                            'custLatitude'    => $item['custLatitude'] ?: null,
                            'custLongitude'   => $item['custLongitude'] ?: null,
                        ]
                    );

                    $success++;

                } catch (Throwable $e) {
                    $failed++;

                    Log::warning('[SyncCustomersJob] ITEM FAILED', [
                        'job_id'     => $jobId,
                        'index'      => $index,
                        'custNumber' => $item['custNumber'] ?? null,
                        'error'      => $e->getMessage(),
                    ]);
                }
            }

            Log::info('[SyncCustomersJob] DONE', [
                'job_id'   => $jobId,
                'total'    => $total,
                'success'  => $success,
                'failed'   => $failed,
                'duration' => round(microtime(true) - $start, 2) . 's',
            ]);

        } catch (Throwable $e) {
            Log::critical('[SyncCustomersJob] FATAL ERROR', [
                'job_id' => $jobId,
                'error'  => $e->getMessage(),
                'trace'  => $e->getTraceAsString(),
            ]);

            throw $e; // biar queue tau ini gagal total
        }
    }
}
