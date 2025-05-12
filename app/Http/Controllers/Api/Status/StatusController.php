<?php

namespace App\Http\Controllers\Api\Status;

use App\Http\Controllers\Controller;
use App\Interfaces\Statuses\StatusInterface;
use App\Models\Task;
use Illuminate\Http\Request;

class StatusController extends Controller
{
     protected $status;
     /**
      * Summary of __construct
      * @param \App\Interfaces\Statuses\StatusInterface $status
      */
     public function __construct(StatusInterface $status){
             $this->status = $status;
     }

     /**
      * Summary of index
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function index(){
        $data=$this->status->getAllStatuses();
        return response()->json($data,$data['code']);
     }

     /**
      * Summary of getTaskStatus
      * @param \App\Models\Task $task
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function getTaskStatus(Task $task){
        $data=$this->status->getStatuses($task);
        return response()->json($data,$data['code']);
     }
     /**
      * Summary of show
      * @param mixed $id
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function show($id){
        $data=$this->status->getStatus($id);
        return response()->json($data,$data['code']);
     }

     /**
      * Summary of destroy
      * @param mixed $id
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function destroy($id){
      $data=  $this->status->deleteStatus($id);
      return response()->json($data,$data['code']);
     }
     /**
      * Summary of restoreStatus
      * @param mixed $id
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function restoreStatus($id){
      $data=  $this->status->restoreStats($id);
      return response()->json($data,$data['code']);
     }
     /**
      * Summary of forceDeleteStatus
      * @param mixed $id
      * @return mixed|\Illuminate\Http\JsonResponse
      */
     public function forceDeleteStatus($id){
        $data=  $this->status->forceDeleteStatus($id);
        return response()->json($data,$data['code']);
     }


}
