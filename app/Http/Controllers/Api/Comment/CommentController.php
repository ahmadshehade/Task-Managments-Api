<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Requests\Comment\ReplayRequest;
use App\Interfaces\Comments\CommetInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comment;

    /**
     * Summary of __construct
     * @param \App\Interfaces\Comments\CommetInterface $comment
     */
    public function __construct(CommetInterface $comment){
       $this->comment = $comment;
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Comment\CommentRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public  function store(CommentRequest $request){
        $data=$this->comment->storeComment($request);
        return $this->dataMessage($data,$data['code']);
    }
    /**
     * Summary of makeReplay
     * @param \App\Http\Requests\Comment\ReplayRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function makeReplay(ReplayRequest $request){
        $data=$this->comment->storeReplay($request);
        return $this->dataMessage($data,$data['code']);
    }
    /**
     * Summary of uodateCommentt
     * @param mixed $id
     * @param \App\Http\Requests\Comment\CommentRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function uodateCommentt($id,CommentRequest $request){
        $data=$this->comment->updateComment($id,$request);
        return $this->dataMessage($data,$data['code']);
    }
    /**
     * Summary of destroy
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $data=$this->comment->deleteComment($id);
        return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(){
        $data= $this->comment->getComments();
        return $this->dataMessage($data,$data['code']);
    }
    /**
     * Summary of show
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id){
        $data=$this->comment->getCommentById($id);
        return $this->dataMessage($data,$data['code']);
    }

}
