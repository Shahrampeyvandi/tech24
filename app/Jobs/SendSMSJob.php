<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;
    protected User $user;
    protected string $pattern;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $pattern,array $data,User $user)
    {
        $this->data = $data;
        $this->user = $user;
        $this->pattern = $pattern;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas = array(
            "pattern_code" => $this->patterncode,
            "originator" => "+983000505",
            "recipient" => '+98' . substr($this->user->mobile, 1),
            "values" => $this->data
        );
        // dd($datas);
        $url = "http://rest.ippanel.com/v1/messages/patterns/send";
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: AccessKey -0E7gN8QTAM9VhfM5Vin5wCjpX5AHYn2a8P-J5Y4T5k='
        ));
        $response = curl_exec($handler);
    }

  
}
