<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table   = 'tasks';
    protected $guarded = [];



    /** start relations **/
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }



    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /** end relations **/
}
