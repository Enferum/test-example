<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearClientsOTPJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * Create a new job instance.
     *
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $codes = $this->client->smsNotification;
        $codes->each(function ($code) {
            if($code->expired === true) {
                $code->delete();
            }
        });
    }
}
