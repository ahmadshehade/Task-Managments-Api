<?php

namespace App\Services\Comments;

use App\Interfaces\Comments\CommetInterface;
use App\Models\Comment;
use App\Models\Task;
use App\Traits\FormatCommentWithReplies;

class CommentService implements CommetInterface{

    use FormatCommentWithReplies;
 /**
  * Summary of storeComment
  * @param mixed $request
  * @throws \Exception
  * @return array{code: int, comment: Comment, message: string, status: bool, task: mixed}
  */
 public function storeComment($request){
    try{
        $validateData=$request->validated();
        $comment=new Comment();
        $comment->fill($validateData);
        $comment->user_id=auth('api')->user()->id;
        $comment->save();
        $task=Task::where('id',$validateData['task_id'])->first();
      $data = [
            'message' => 'Successfully Created Comment.',
            'comment' => $comment,
            'task'=>$task->title,
            'code' => 201,
            'status' => true
        ];


     return  $data;
    }catch(\Exception $e){
        throw new \Exception($e->getMessage(),500);
    }
 }

  /**
   * Summary of storeReplay
   * @param mixed $request
   * @throws \Exception
   * @return array{code: int, message: string, parent: \Illuminate\Database\Eloquent\Collection<int, Comment>, replay: Comment, status: bool}
   */
  public function storeReplay($request){
    try{
        $validateData=$request->validated();
        $comment=Comment::where('id',$validateData['parent_id'])->first();
        if(!$comment){
            throw new \Exception('Comment not found.',500);
        }
        $replay=new Comment();
        $replay->fill($validateData);
        $replay->user_id=auth('api')->user()->id;
        $replay->task_id=$comment->task_id;
        $replay->save();
        $data = [
            'message' => 'Successfully Created Comment.',
            'replay'=>$replay,
            'parent' => $replay->parent()->get(),
            'code' => 201,
            'status' => true
        ];
        return $data;


    }catch(\Exception $e){
        throw new \Exception($e->getMessage(),500);
    }
  }

    /**
     * Summary of updateComment
     * @param mixed $id
     * @param mixed $request
     * @throws \Exception
     * @return array{code: int, comment: Comment, message: string, status: bool}
     */
    public function updateComment($id,$request){
        try{
            $validateData=$request->validated();
            $comment=Comment::where('id',$id)
            ->where('user_id',auth('api')->user()->id)->first();
            if(!$comment){
                throw new \Exception('Comment Not Found',500);
            }
            $comment->fill($validateData);
            $comment->save();
            $data=[
                'message'=> 'Successfully Updated Comment.',
                'comment'=>$comment,
                'code'=>200,
                'status'=>true
            ];
         return $data;

        }catch(\Exception $e){
            throw new \Exception($e->getMessage(),500);
        }
    }




    /**
     * Summary of deleteComment
     * @param mixed $id
     * @throws \Exception
     * @return array{code: int, message: string, status: bool}
     */
    public function deleteComment($id){
        $comment=Comment::where('id',$id)->where('user_id',auth('api')->user()->id)->first();
        if(!$comment){
            throw new \Exception('Comment Not Found',500);
        }
        $comment->delete();
        $data=[
            'message'=> 'Successfully Deleted Comment.',
            'code'=>200,
            'status'=>true
        ];
        return $data;
    }


/**
 * Summary of getComments
 * @return array{code: int, comments: array, message: string}
 */
public function getComments()
{
    $comments = Comment::whereNull('parent_id')->get();

    $data = [];

    foreach ($comments as $comment) {
        $data[] = $this->formatCommentWithReplies($comment);
    }

    $dataComment=[
        'message' => 'Comments with nested replies',
        'comments' => $data,
        'code'=>200
    ];
    return $dataComment;
}



    /**
     * Summary of getCommentById
     * @param mixed $id
     * @throws \Exception
     * @return array{code: int, comment: array|array{body: mixed, id: mixed, replies: array, user: mixed, message: string, status: bool}}
     */
    public function getCommentById($id){
        $comment=Comment::find($id);
        if(!$comment){
            throw new \Exception('Comment Not Found',500);
        }
        $replaies=$this->formatCommentWithReplies($comment);
        $data=[
            'message'=> 'Successfully Deleted Comment.',
            'comment' => $replaies,
            'code'=>200,
            'status'=>true
        ];
        return $data;
    }
}
