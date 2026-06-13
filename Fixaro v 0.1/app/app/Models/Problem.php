<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = [
        'user_id', 
        'description', 
        'category', 
        'photo_path', 
        'location', 
        'status', 
        'is_urgent',
        'address',
        'lat',
        'lng',
        'approx_lat',
        'approx_lng'
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'lat' => 'float',
        'lng' => 'float',
        'approx_lat' => 'float',
        'approx_lng' => 'float',
    ];

    /**
     * Generates approximate coordinates using a circular offset.
     * Offset is randomly chosen between 300m and 500m.
     */
    public function generateApproximateCoordinates()
    {
        if (!$this->lat || !$this->lng) return;

        // Radius between 300m and 500m
        $radius = rand(300, 500); 
        $angle = deg2rad(rand(0, 360));

        // Offset in meters
        $dx = $radius * cos($angle);
        $dy = $radius * sin($angle);

        // Earth's radius in meters (approx)
        $earthRadius = 6378137;

        // Coordinate offsets in radians
        $dLat = $dy / $earthRadius;
        $dLng = $dx / ($earthRadius * cos(deg2rad($this->lat)));

        // New coordinates
        $this->approx_lat = $this->lat + rad2deg($dLat);
        $this->approx_lng = $this->lng + rad2deg($dLng);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
