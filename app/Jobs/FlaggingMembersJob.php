<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FlaggingMembersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reset = DB::update('UPDATE participants p SET p.member = false');
        Log::info('FlaggingMembersJob: Resetted', [now()->toDateTimeString(), $reset]);
        $affected = DB::update('UPDATE participants p SET p.member = TRUE WHERE EXISTS (SELECT 1 FROM members m WHERE m.staff_id = p.staff_id)');
        Log::info('FlaggingMembersJob: Updated', [now()->toDateTimeString(), $affected]);
    }
}
