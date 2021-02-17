<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $tables = ['questions'];
    protected $guard = ['id'];
    protected $fillable = ['exam_id', 'question', 'answers', 'correct', 'degree', 'attach'];

    /*
    *****************************************************************************
    *************************** Begin RELATIONS Area ****************************
    *****************************************************************************
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    } // To Return The Relation Between Question and User

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    } // To Return The Relation Between Question and Exam

    /*
    *****************************************************************************
    *************************** Begin SCOPE Area ********************************
    *****************************************************************************
    */
    public function scopeSearch($query, $request)
    {
        return $query->where($request['column'], 'LIKE', "%" . $request['text'] . "%");
    } // To do Some Query

    public function getAttachPathAttribute()
    {
        if ($this->attach)
            return asset('uploads/images/questions/' . $this->attach);
    } // To Return The Image Path
}
