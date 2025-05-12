<?php

namespace App\Services\Tasks;

use App\Interfaces\Tasks\TaskInterface;
use App\Models\Status;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskService implements TaskInterface{

   /**
    * Summary of index
    * @return array{code: int, data: array, message: string}
    */
   public function index()
        {
            $tasks = Task::orderBy("id", "desc")->get();
            $taskList = [];

            foreach ($tasks as $task) {
                $lastStatus = $task->statuses()->orderBy("id", "desc")->first();
                $taskList[] = [
                    'task' => $task,
                    'last_status' => $lastStatus,
                ];
            }

            return [
                'message' => 'All Tasks',
                'code' => 200,
                'data' => $taskList,
            ];
        }




    /**
     * Summary of store
     * @param mixed $request
     * @return array|array{code: int, data: Task, message: string|mixed|\Illuminate\Http\JsonResponse}
     */
    public function store($request){
        try{

            DB::beginTransaction();
            $dataValidated = $request->validated();
            $data=[];
            $task=new Task();
            $task->fill($dataValidated);
            $task->user_id=auth('api')->user()->id;
            $task->save();


           if($task){

             $status=new Status();
             $status->task_id=$task->id;
             $status->name="pending";
             $status->save();


                 DB::commit();
                $data=[
                'message'=>'Task created successfully',
                'data'=>$task,
                'code'=>201

            ];

           }

            return $data;

        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Summary of show
     * @param mixed $task
     * @return array{code: int, data: mixed, last_status: mixed, message: string}
     */
    public function show( $task){
        $lastSatus=$task->statuses()->orderBy("id", "desc")->first();
        $data=[
            'message'=>'Task found successfully',
            'data'=>$task,
            'last_status'=>$lastSatus,
            'code'=>200
        ];
        return $data;
    }

    /**
     * Summary of update
     * @param mixed $request
     * @param mixed $task
     * @throws \Exception
     * @return array{code: int, data: array{task: mixed, message: string}}
     */
    public function update($request , $task){
        try{
            DB::beginTransaction();
            $dataValidated = $request->validated();
            $task->fill($dataValidated)->save();
             $latestStatus = $task->statuses()->latest()->first();
             if($request->name){
             if (!$latestStatus || $latestStatus->name !== $dataValidated['name']) {
                $status=new Status();
                $status->task_id=$task->id;
                $status->name=$dataValidated['name'];
                $status->save();
             }
            }

            DB::commit();
        $data = [
                    'message' => 'Successfully updated Task: ' . $task->title,
                    'data' => [
                        'task' => $task,

                    ],
                    'code' => 200
                ];

                return $data;



        }catch(Exception $e){
            DB::rollBack();
            throw  new Exception($e->getMessage(),500);
        }
    }

    /**
     * Summary of destroy
     * @param mixed $task
     * @throws \Exception
     * @return array{code: int, data: array{task: mixed, message: string}}
     */
    public function destroy( $task){
        try{
            DB::beginTransaction();
            $taskStatuses=$task->statuses;
            foreach($taskStatuses as $taskStatus){
                $taskStatus->delete();
            }
            $task->delete();
            DB::commit();
            $data=[
                'message'=>'Successfully deleted Task: '.$task->title,
                'code'=>200,
                'data'=>[
                    'task'=>$task
                ]
            ];
            return $data;
        }catch(Exception $e){
            DB::rollBack();
            throw  new Exception($e->getMessage(),500);

        }
    }

    /**
     * Summary of restoreTask
     * @param mixed $taskId
     * @throws \Exception
     * @return array{code: int, data: array{statuses: mixed, task: \Illuminate\Database\Eloquent\Collection, message: string}}
     */
    public function restoreTask($taskId){
        try{
           DB::beginTransaction();
              $task = Task::onlyTrashed()->find($taskId);
               if ($task) {
                    $task->restore();
                  }
            $taskStatuses = $task->statuses()->onlyTrashed()->get();
            foreach($taskStatuses as $taskStatus){
             $taskStatus->restore();
            }
            DB::commit();
            $data=[
            'message' => 'Successfully restored Task: ' . $task->title,
            'code' => 200,
            'data' => [
                'task' => $task,
                'statuses' => $taskStatuses,
                ]
            ];
            return $data;

        }catch(Exception $e){
            DB::rollBack();
            throw  new Exception($e->getMessage(),500);
    }

}


 /**
  * Summary of forceDestroy
  * @param mixed $taskId
  * @throws \Exception
  * @return array{code: int, data: array{task: \Illuminate\Database\Eloquent\Collection, message: string}}
  */
 public  function forceDestroy($taskId){
     try{
            DB::beginTransaction();
            $task=Task::onlyTrashed()->find($taskId);
            if(!$task)
            {
                throw new Exception('Task not Trashed or not exists',404);
            }
            $taskStatuses=$task->statuses;
            foreach($taskStatuses as $taskStatus){
                $taskStatus->forcedelete();
            }
            $task->forcedelete();
            DB::commit();
            $data=[
                'message'=>'Successfully deleted Task: '.$task->title,
                'code'=>200,
                'data'=>[
                    'task'=>$task
                ]
            ];
            return $data;
        }catch(Exception $e){
            DB::rollBack();
            throw  new Exception($e->getMessage(),500);

        }
 }

 /**
  * Summary of search
  * @param mixed $request
  * @throws \Exception
  * @return array[]|array{code: int, message: string}
  */
 public function search($request)
 {
   $validator = Validator::make(
        ['search' => $request->search],
        ['search' => ['required', 'in:low,medium,high']]
   );
    if($validator->fails()){
        throw new Exception($validator->errors(),500);
    }
    $tasks=Task::where('priority',$request->search)
    ->orderBy('id','desc')->get();
    if(!$tasks){
        throw new Exception('Tasks not found',404);
    }
    $data=[
        'message'=>'Tasks found',
        'code'=>200,
    ];
    foreach($tasks as $task){
        $data[]=[
            'taske'=>$task,
            'lastStatatus'=>$task->statuses()->orderBy('id','desc')->first(),
            'comments'=>$task->comments()->get(),
        ];
    }
    return $data;

 }

}
