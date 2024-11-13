<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'address',
        'email',
        'password',
        'dob',
        'gender',
        'user_pic',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Update the user's profile with the given data and image.
     *
     * @param array $data
     * @param UploadedFile|null $image
     * @return void
     */
    public function updateProfile(array $data, $image = null)
{
    $this->first_name = $data['first_name'];
    $this->middle_name = $data['middle_name'];
    $this->last_name = $data['last_name'];
    $this->phone = $data['phone'];
    $this->dob = $data['dob'];
    $this->address = $data['address'];

    // Handle profile picture upload
    if ($image) {
        // Delete old profile picture if it exists
        if ($this->user_pic) {
            Storage::disk('public')->delete('profile_pics/' . $this->user_pic);
        }

        // Store new profile picture
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/profile_pics', $imageName);
        $this->user_pic = $imageName;
    }

    $this->save();
}

public function funds()
{
    return $this->hasMany(Fund::class, 'owner_email', 'email');
}
public function donations()
    {
        return $this->hasMany(Donation::class);
    }
    
}
