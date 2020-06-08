<?php

namespace App\Console\Commands;

use App\Models\Status;
use App\Models\Win;
use Exception;
use http\Client;
use http\Client\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TransferMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'money:transfer {--limit=2}';

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
     * @return mixed
     */
    public function handle()
    {
        $statusToTransfer = Status::whereSlug('to_transfer')->get()->first();
        $statusTransferred = Status::whereSlug('transferred')->get()->first();
        $winsToTransfer = Win::whereStatusId($statusToTransfer->id)->with('user')->take($this->option('limit'))->get();

        $this->info('Start transfer for '.$winsToTransfer->count());

        $counter = 0;
        collect($winsToTransfer)->each(function (Win $win) use ($statusTransferred, &$counter) {
            try {
                $responseStatus = 200;
                // $client = new \GuzzleHttp\Client();
                // $response = $client->post($URI, $headers, ['json' => $body]);
                // $responseStatus = $response->getStatusCode();
                $responseStatus == 200 && $win->update(['status_id' => $statusTransferred->id]) && $counter+=1;
            } catch (Exception $e) {
                // Log::stack(['console'])->error(sprintf('Was not updated with error: %s', $e->getMessage()));
            }
        });

        $this->info('Success for '.$counter);
    }
}

