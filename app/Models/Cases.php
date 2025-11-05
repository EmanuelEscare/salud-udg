<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    protected $connection = 'cbr';

    protected $table = 'cases';

    protected $primaryKey = 'id';

    public $timestamps = true;
    const UPDATED_AT = null; 

    protected $fillable = [
        'id',
        'disease_code',
        'notes',
        'is_active',
        'created_at',
    ];

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'case_symptom_weights',
            'case_id',        
            'symptom_code',   
            'id',             
            'code'            
        )->withPivot('weight');
    }
}
