<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\apilog;
use Curl;

class InsertWagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $starttime;
    protected $endtime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($starttime, $endtime)
    {
        $this->starttime = $starttime;
        $this->endtime = $endtime;
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle()
    {
        //
        // echo $this->starttime;
        // echo $this->endtime;

        $params = [
            'start' => $this->starttime,
            'end' => $this->endtime,
            'from' => '0',
        ];

        $curl = new Curl\Curl();

        $response = $curl->post('http://train.rd6', $params);

        $response = json_decode($curl->response, true);


        foreach ($response['hits']['hits'] as $data) {

            $time = explode('+', $data['_source']['@timestamp']);

            $apilog = new apilog;

            $apilog->_index = $data['_index'];
            $apilog->_type = $data['_type'];
            $apilog->_id = $data['_id'];
            $apilog->server_name = $data['_source']['server_name'];
            $apilog->request_method = $data['_source']['request_method'];
            $apilog->status = $data['_source']['status'];
            $apilog->size = $data['_source']['size'];
            $apilog->timestamp = $time[0];

            $apilog->save();
        }
    }
}
