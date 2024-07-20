<?php

namespace App\Models;

use App\Http\Resources\CustomerResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['nama', 'email', 'password', 'nomor_hp', 'foto', 'alamat'];


    public function customerDetail()
    {
        return $this->hasMany(CustomerResource::class);
    }
}
