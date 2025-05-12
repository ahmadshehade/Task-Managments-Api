<?php

namespace App\Interfaces\Comments;


interface  CommetInterface{

    public function storeComment($request);

    public function updateComment($id,$request);


    public function deleteComment($id);


    public function getComments();


    public function getCommentById($id);


    public function storeReplay($request);







}
