<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MaterialRequest Model
 * 
 * Represents material requests submitted by users, optionally linked to maintenance requests.
 * This model demonstrates optional relationships and complex authorization patterns.
 * 
 * Educational Note: Shows how to handle nullable foreign keys and 
 * conditional relationships in Laravel Eloquent.
 */
class MaterialRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'requester_id',
        'maintenance_request_id',
        'item_description',
        'quantity',
        'cost',
        'funding_source',
        'status',
    ];

    /**
     * Get the user who submitted this material request.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Get the maintenance request this material request is associated with (optional).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }
}
