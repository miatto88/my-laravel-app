<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    protected $table = "todos";

    protected $fillable = [
        'title', 'user_id', 'status',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function getTodoList($search) {
        $todos = Todo::query();
        if(isset($search->title)) {
            $todos->where('title', 'LIKE', "%$search->title%");
        }
        if(isset($search->user_name)) {
            $todos->whereIn('user_id', function($query) use ($search) {
                $query->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%$search->user_name%");
            });
        }
        if(isset($search->user_name)) {
            $todos->whereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', "%$search->user_name%");
            });
        }

        $todos = $todos->paginate( config('const.PAGINATE.LINK_NUM') );

        return $todos;
    }
}
