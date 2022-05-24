<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model {
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function proof() {
        return $this->hasMany(JobProve::class, 'job_id');
    }
    public function proofNotification() {
        return $this->hasMany(JobProve::class, 'job_id')->where('notification', 0);
    }

    public function scopePending(){
        return $this->where('status',0);
    }

    public function scopeApproved(){
        return $this->where('status',1);
    }

    public function scopeCompleted(){
        return $this->where('status',2);
    }

    public function scopePause(){
        return $this->where('status',3);
    }

    public function scopeRejected(){
        return $this->where('status',9);
    }
}
