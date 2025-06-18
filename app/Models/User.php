<?php

declare(strict_types = 1);

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use App\Traits\AuthorizationChecker;
use App\Traits\HasGravatar;
use Illuminate\Auth\Notifications\ResetPassword as DefaultResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasGravatar, HasRoles, Notifiable, AuthorizationChecker;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function actionLogs()
    {
        return $this->hasMany(ActionLog::class, 'action_by');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Check if the request is for the admin panel
        if (request()->is('admin/*')) {
            $this->notify(new AdminResetPasswordNotification($token));
        } else {
            $this->notify(new DefaultResetPassword($token));
        }
    }

    /**
     * Define a hasOneThrough relationship to get the Perusahaan (Company)
     * through the Karyawan (Employee) model.
     *
     * A User has one Karyawan.
     * A Karyawan belongs to one Perusahaan.
     * So, a User has one Perusahaan through Karyawan.
     *
     * The parameters for hasOneThrough are:
     * 1. The name of the final model (Perusahaan::class).
     * 2. The name of the intermediate model (Karyawan::class).
     * 3. The foreign key on the intermediate model (karyawans) that links to this model (users) (e.g., 'user_id').
     * 4. The foreign key on the intermediate model (karyawans) that links to the final model (perusahaans) (e.g., 'perusahaan_id').
     * 5. The local key on this model (users) (defaults to 'id').
     * 6. The local key on the final model (perusahaans) (defaults to 'id').
     */
// User.php
    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class);
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }
}
