<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['patient_id', 'report_file', 'test_type', 'notes', 'uploaded_by'];

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function uploader() {
        return $this->belongsTo(Manager::class, 'uploaded_by');
    }
}
