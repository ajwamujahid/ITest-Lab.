<?php
namespace App\Jobs;

use App\Models\Rider;
use App\Models\RiderReview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyRiderReviewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $review;

    public function __construct(RiderReview $review)
    {
        $this->review = $review;
    }

  

    public function handle()
    {
        Log::info('🔁 NotifyRiderReviewJob started for review ID: ' . $this->review->id);
    
        $rider = \App\Models\Rider::find($this->review->rider_id);
    
        if ($rider) {
            $rider->new_review_alert = true;
            $rider->save();
    
            Log::info("✅ Rider ID {$rider->id} updated with new_review_alert = true");
        } else {
            Log::warning("⚠️ Rider not found with ID: {$this->review->rider_id}");
        }
    }
    
}
