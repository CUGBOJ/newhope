<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    //
    protected $fillable = [
        'Title',
        'Description',
        'Input',
        'Output',
        'Sample_input',
        'Sample_output',
        'Author',
        'Hint',
        'AC_number',
        'Submit_number',
        'AC_user_number',
        'Submit_user_number',
        'Time_limit',
        'Memory_limit',
        'created_at',
        'updated_at',
    ];
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}