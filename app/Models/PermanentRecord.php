<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermanentRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "permanent_records";

    protected $fillable = [
        'client_id',
        'accounting_office_id',
        'file_id',
        'pdf_file_id',
        'request_sent_at',
        'request_sent_by_staff_id',
        'has_video',
        'with_approval',
        'comments',
        'viewed_by_staff_id',
        'response_completed_at',
        'is_approved',
        'viewing_date',
    ];

    protected $dates = [
        'request_sent_at',
        'response_completed_at',
        'viewing_date'
    ];

    public function host():HasOne
    {
        return $this->hasOne(AccountingOffice::class);
    }

    public function client():HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function pdf():HasOne
    {
        return $this->hasOne(Files::class, 'id', 'pdf_file_id');
    }

    public function document():HasOne
    {
        return $this->hasOne(Files::class, 'id', 'file_id');
    }

    public function uploader():HasOne
    {
        return $this->hasOne(AccountingOfficeStaff::class, 'id', 'request_sent_by_staff_id');
    }

    public function viewer():HasOne
    {
        return $this->hasOne(ClientStaff::class, 'id', 'viewed_by_staff_id');
    }
}
