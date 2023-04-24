<?php

namespace App\Console\Commands;

use App\Models\Notify;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SendlineMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendLineMessage:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');
        $notifies = Notify::where('status', 1)
            ->where('starttime', '<=', $now)
            ->where('endtime', '>=', $now)
            ->get();
        $data = [];
        if (count($notifies) > 0) {
            $i = 0;
            foreach ($notifies as $item) {
                $data[$i]['title'] = $item['title'];
                $data[$i]['content'] = $item['content'];
                $i++;
            }
        }

        $message = '';
        foreach ($data as $item) {
            $message .= "標題：{$item['title']}\n內容：{$item['content']}\n";
            $message .= str_repeat('-', 10) . "\n"; // 使用 '-' 作為分隔線，重複10次
        }
        $linetoken = "L8frT8mwtLcepK6w50N47bAYs8Ac4HH6UmGTkA25yuz";
        $client = new Client();
        $response = $client->post('https://notify-api.line.me/api/notify', [
            'headers' => [
                'Authorization' => 'Bearer ' . $linetoken,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'message' => $message,
            ],
        ]);
        if ($response->getStatusCode() == 200) {
            $this->info('Send line messages successfully.');
            return 0;
        } else {
            $this->error('Failed to send line messages.');
            return 1;
        }
    }
}
