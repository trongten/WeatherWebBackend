<?php

namespace App\Console\Commands;

use App\Mail\WeatherMail;
use App\Models\Subscriber;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendDailyReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-report-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Report Email';

    /**
     * Execute the console command.
     */
    public function handle()
    {   $apiKey = env('WEATHER_API_KEY');
        $apiURL = env('WEATHER_API_URL');
        $url = "http://$apiURL?key=$apiKey&q=vietnam&days=4&aqi=no&alerts=no";
        $client = new Client();

        Log::info('Starting SendDailyReportEmail command...');

            $response = $client->get($url);
            $responseData = $response->getBody()->getContents();
            $data = json_decode($responseData, true);
            $listEmails = Subscriber::query()->where(['status',1])->pluck('email')->toArray();
            foreach ($listEmails as $email) {
                Mail::to($email)->send(new WeatherMail($data));
            } 
    }
}
