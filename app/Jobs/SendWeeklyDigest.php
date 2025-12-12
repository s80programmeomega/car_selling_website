<?php

namespace App\Jobs;

use App\Mail\car\WeeklyDigest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Job to send weekly digest emails to subscribed users
 */
class SendWeeklyDigest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get users who want to receive email digest
        User::where('receive_email_digest', true)
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    Mail::to($user)->queue(new WeeklyDigest($user));
                }
            });
    }
}
