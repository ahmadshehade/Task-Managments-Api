<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Interfaces\Tasks\TaskInterface;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskManager;
    /**
     * Summary of __construct
     * @param \App\Interfaces\Tasks\TaskInterface $taskManager
     */
    public function __construct(TaskInterface $taskManager){
        $this->taskManager = $taskManager;
    }

    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(){
        $data=$this->taskManager->index();
       return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Task\TaskRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request){
      $data=$this->taskManager->store($request);
      return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of show
     * @param \App\Models\Task $task
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Task $task){
        $data=$this->taskManager->show($task);
        return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Task\TaskRequest $request
     * @param \App\Models\Task $task
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, Task $task){
        $data=$this->taskManager->update($request,$task);
        return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of destroy
     * @param \App\Models\Task $task
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task){
        $data=$this->taskManager->destroy($task);
        return $this->dataMessage($data,$data['code']);
    }



    /**
     * Summary of restoreTask
     * @param \App\Models\Task $task
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function restoreTask( $task){
        $data=$this->taskManager->restoreTask($task);
           return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of forceDeleteTask
     * @param mixed $taskId
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function forceDeleteTask( $taskId){
        $data=$this->taskManager->forceDestroy($taskId);
        return $this->dataMessage($data,$data['code']);
    }


    /**
     * Summary of searchByPriority
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function searchByPriority(Request $request){
      $data=$this->taskManager->search($request);
      return $this->dataMessage($data,$data['code']);
    }



}
