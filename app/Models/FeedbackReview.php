<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_message',
        'feedback_date'
    ];
}