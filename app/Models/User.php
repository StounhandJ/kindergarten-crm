<?php

namespace App\Models;

use App\Models\Types\Position;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'login',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getByLogin($login): User
    {
        return User::where("login", $login)->first() ?? new User();
    }

    public static function getByLoginAndPassword($login, $password): User
    {
        return User::where("login", $login)->first() ?? new User();
    }

    public static function getById($id): User
    {
        return User::where("id", $id)->first() ?? new User();
    }

    public static function make($login, $password)
    {
        return User::query()->make(["login" => $login, "password" => $password]);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function getLogin()
    {
        return $this->attributes['login'];
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPosition(): Position
    {
        return $this->getStaff()->getPosition();
    }

    public function getStaff(): ?Staff
    {
        return $this->hasOne(Staff::class, "user_id", "id")->getResults();
    }

    /**
     * @param string[]|string $positions
     * @return bool
     */
    public function checkPosition(array|string $positions): bool
    {
        $e_name_position = $this->getStaff()->getPosition()->getEName();
        $result = false;
        if (is_array($positions))
        {
            foreach ($positions as $position)
                if ($e_name_position==$position)
                    $result = true;
        }
        elseif (is_string($positions) && $positions==$e_name_position) {
            $result = true;
        }
        return $result;
    }
}
