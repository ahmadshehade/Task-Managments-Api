<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table='comments';
    protected $fillable=[
        'task_id',
        'body',
        'parent_id'
    ];
    protected $guarded=['user_id'];

    /**
     * Summary of user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Comment>
     */
    public  function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    /**
     * Summary of task
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Task, Comment>
     */
    public function task(){
        return $this->belongsTo(Task::class,'task_id','id');
    }
    /**
     * Summary of parent
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Comment, Comment>
     */
    public function parent(){
        return $this->belongsTo(Comment::class,'parent_id','id');
    }
    /**
     * Summary of replaies
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment, Comment>
     */
    public function replaies(){
        return $this->hasMany(Comment::class,'parent_id','id');
    }

}
