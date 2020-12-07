<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Link;
use App\Analytic;

class ProcessAnalytics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $link;
    protected $ip;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Link $link, $ip)
    {
        $this->link = $link;
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $analytics = new Analytic;
        $analytics->ip = $this->ip;
        $analytics->link_id = $this->link->id;
        $analytics->save();
    }
}
