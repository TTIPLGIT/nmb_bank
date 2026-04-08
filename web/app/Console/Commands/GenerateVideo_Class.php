<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class GenerateVideo_Class extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:generate_video_class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
   
    public function handle()
{
    Log::info('Every 5 minutes cron started');

    $aiResponseClasses = DB::table('ai_course_response_classes')
        ->whereNull('video_status')
        ->get();
    //  Log::info('Batch status response', [
    //             'aiResponseClasses'      => $aiResponseClasses,
                
    //         ]);
    if ($aiResponseClasses->isEmpty()) {
        Log::info('No pending AI response classes found');
        return Command::SUCCESS;
    }

    $url = 'http://20.164.0.23:3300/batch-status';

    foreach ($aiResponseClasses as $class) {

        $payload = [
            $class->task_id
        ];

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->post($url, $payload);
        Log:info ($response);
            if (!$response->successful()) {
                Log::error('Batch status API failed', [
                    'task_id' => $class->task_id,
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                ]);
                continue;
            }

            $output = $response->json();

            $batchStatus = data_get($output, 'batch_status');
            $taskStatus  = data_get($output, 'tasks.0.result.status');
            $videoUrl    = data_get($output, 'tasks.0.result.video_url');

            Log::info('Batch status response', [
                'task_id'      => $class->task_id,
                'batch_status' => $batchStatus,
                'task_status'  => $taskStatus,
                'video_url'    => $videoUrl,
            ]);

            if ($batchStatus === 'completed') {
                DB::table('ai_course_response_classes')
                    ->where('id', $class->id)
                    ->update([
                        'video_status' => $taskStatus,
                        'video_link'    => $videoUrl,
                        'updated_at'   => now(),
                    ]);
            }

        } catch (\Throwable $e) {
            Log::error('Batch status API exception', [
                'task_id' => $class->task_id,
                'message' => $e->getMessage(),
            ]);
        }
    }

    return Command::SUCCESS;
}

    
}