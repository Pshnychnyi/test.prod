<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Filters\User\UserSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function canDo($alias, $require = false) {
        if(is_array($alias)) {
            foreach ($alias as $item) {
              $result = $this->canDo($item);
              if($result && !$require) {
                  return true;
              }elseif(!$result && $require) {
                  return false;
              }
            }
        }else {
            foreach ($this->roles as $role) {
                foreach ($role->perms as $permission){
                    if($permission->alias === $alias) {
                        return true;
                    }
                 }
            }
        }

        return $require;
    }

    public function hasRole($alias, $require = false)
    {

        if(is_array($alias)) {
            foreach ($alias as $item) {
                $result = $this->hasRole($item);
                if($result && !$require) {
                    return true;
                }elseif(!$result && $require) {
                    return false;
                }
            }
        }else {
            foreach ($this->roles as $role) {
                if($role->alias === $alias) {
                    return true;
                }
            }
        }

        return $require;
    }

    public function getRoles() {
        if($this->roles) {
            return $this->roles;
        }
        return false;
    }

    public function getRoleTitleAttribute()
    {
        return $this->roles->first()->title;
    }

    public function getRoleIdAttribute()
    {
        return $this->roles->first()->id;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getUserBySearch(\Illuminate\Http\Request $request)
    {
        $builder = (new UserSearch())->apply($request);
        return $builder;
    }
}
