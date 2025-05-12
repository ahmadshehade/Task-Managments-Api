<?php

namespace App\Services\Statuses;

use App\Interfaces\Statuses\StatusInterface;
use App\Models\Status;

class StatusService implements  StatusInterface{
    /**
     * Summary of getStatus
     * @param mixed $id
     * @throws \Exception
     * @return array{code: int, message: string, status: \Illuminate\Database\Eloquent\Collection<int, Status>}
     */
    public function getStatus($id){
        $status=Status::find($id);
        if(!$status){
            throw new \Exception("Status not found",404);
        }else{
            $data=[
                'message'=>'Status found',
                'status'=>$status,
                'code'=>200
            ];
            return $data;
        }
    }
    /**
     * Summary of getStatuses
     * @param mixed $task
     * @throws \Exception
     * @return array{code: int, message: string, status: mixed}
     */
    public function getStatuses($task){
        $taskStatuses=$task->statuses()->orderBy('id','desc')->get();
        if($taskStatuses->isEmpty()){
            throw new \Exception(" Empty data found",404);
        }else{
            $data=[
                'message'=>'Status found',
                'status'=>$taskStatuses,
                'code'=>200
            ];
            return $data;
        }

    }
    /**
     * Summary of getAllStatuses
     * @throws \Exception
     * @return array{code: int, message: string, status: \Illuminate\Database\Eloquent\Collection<int, Status>}
     */
    public function  getAllStatuses(){
        $statuses=Status::orderBy('id','desc')->get();
        $resault=[];
        if($statuses->isEmpty()){
            throw new \Exception(" Empty data found",404);
        }else{
           foreach($statuses as $status){
            $resault[]=$status;

           }
           $data=[
                'message'=>'Status found',
                'status'=>$resault,
                'code'=>200
            ];

            return $data;
        }
    }
    /**
     * Summary of deleteStatus
     * @param mixed $id
     * @throws \Exception
     * @return array{code: int, message: string, status: \Illuminate\Database\Eloquent\Collection<int, Status>}
     */
    public function deleteStatus($id){
        $status=Status::find($id);
        if(!$status){
            throw new \Exception('Status not found',404);
        }
        $status->delete();
        $data=[
            'message'=>'Status deleted',
            'status'=>$status,
            'code'=>200
        ];
        return $data;
    }

    /**
     * Summary of restoreStats
     * @param mixed $id
     * @throws \Exception
     * @return array{code: int, message: string, status: \Illuminate\Database\Eloquent\Collection<int, mixed>}
     */
    public function restoreStats($id){
        $status=Status::onlyTrashed()->find($id);
        if(!$status){
            throw new \Exception('Status not found',404);
        }
        $status->restore();
        $data=[
            'message'=>'Status restored',
            'status'=>$status,
            'code'=>200
        ];
        return $data;
    }

    /**
     * Summary of forceDeleteStatus
     * @param mixed $id
     * @throws \Exception
     * @return array{code: int, message: string, status: \Illuminate\Database\Eloquent\Collection<int, mixed>}
     */
    public function  forceDeleteStatus($id){
        $status=Status::onlyTrashed()->find($id);
        if(!$status){
            throw new \Exception('Status not found',404);
        }
        $status->forceDelete();
        $data=[
            'message'=>'Status deleted',
            'status'=>$status,
            'code'=>200
        ];
        return $data;
    }
}

