<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * MaintenanceRequest Model
 * 
 * Represents maintenance requests submitted by users (admin/staff).
 * This model handles the relationship between users and their maintenance requests,
 * allowing for role-based access control and status tracking.
 * 
 * Educational Note: This demonstrates Eloquent model relationships and 
 * how to structure models for authorization and data access patterns.
 */
class MaintenanceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'requester_id',
        'floor',
        'location', 
        'title',
        'description',
        'priority',
        'status',
    ];

    /**
     * Get the user who submitted this maintenance request.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Get the material requests associated with this maintenance request.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materialRequests()
    {
        return $this->hasMany(MaterialRequest::class);
    }
}
