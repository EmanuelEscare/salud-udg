<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $connection = 'cbr';

    protected $table = 'symptoms';

    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
        'category_code',
    ];

    public function cases()
    {
        return $this->belongsToMany(Cases::class, 'case_symptom_weights',
            'symptom_code',   
            'case_id',        
            'code',           
            'id'              
        )->withPivot('weight');
    }
}
