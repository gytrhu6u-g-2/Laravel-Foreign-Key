<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    protected $table = 'userInformations';

    protected $fillable = [
        'name',
        'department_id',
        'mail',
    ];

    public function department() {
        return $this->hasMany(Departmant::class);
    }
}
