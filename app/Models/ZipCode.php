<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;
    
    protected $table = 'zipcodes';

    protected $primaryKey = 'zip_code';

    protected $fillable = [
        'zip_code',
        'locality',
        'federal_entity',
        'settlements',
        'municipality'
    ];
}
