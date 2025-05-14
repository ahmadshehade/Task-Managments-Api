<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Task extends Model
{
      use SoftDeletes,HasFactory;
   protected  $fillable=[
    'title',
    'description',
    'due_date',
    'priority'
   ];

   protected $table='tasks';
   protected $guarded=['user_id'];


   /**
    * Summary of statuses
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Status, Task>
    */
   public function statuses(){
    return $this->hasMany(Status::class,'task_id','id');
   }

   /**
    * Summary of user
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Task>
    */
   public function user(){
    return $this->belongsTo(User::class,'user_id','id');
   }

   /**
    * Summary of comments
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Comment, Task>
    */
   public function comments(){

    return $this->hasMany(Comment::class,'task_id','id');
   }

}
