<?php

namespace App\Interfaces\Tasks;

use App\Models\Task;

interface TaskInterface{

    public function index();

    public function store($request );

    public function show( $task);

    public function update($request , $task);

    public function destroy( $task);

    public function restoreTask( $taskId);


    public function forceDestroy( $taskId);



    public function search($request);


}
