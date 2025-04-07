<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'trade_license_path',
        'tin_certificate_path',
        'bin_certificate_path',
        'type',
        'owner_id'
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
        'nid_verified' => 'boolean',
    ];

    /**
     * Get the owner of the company
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get all users belonging to this company
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all documents for this company
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Scope for transporter companies
     */
    public function scopeTransporters($query)
    {
        return $query->where('type', 'transporter');
    }

    /**
     * Scope for enterprise companies
     */
    public function scopeEnterprises($query)
    {
        return $query->where('type', 'enterprise');
    }
    
}


