<?php

namespace App\Console\Commands;

use App\Services\AccountsService;
use Illuminate\Console\Command;
use LaravelCode\Middleware\Factories\OAuthClient;
use LaravelCode\Middleware\Services\AccountService;

class WhoAmI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'who:am:i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var OAuthClient
     */
    private $client;
    /**
     * @var AccountService
     */
    private $service;

    /**
     * Create a new command instance.
     *
     * @param OAuthClient $client
     * @param AccountService $service
     */
    public function __construct(OAuthClient $client, AccountService $service)
    {
        parent::__construct();
        $this->client = $client;
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->client->setUp();
        $result = $this->service->getProfile($this->client->getAccessToken());
        dd($result);
    }
}
