<?php

namespace App\Interfaces\Statuses;


interface StatusInterface{
    public function getStatus($id);

    public function getStatuses($task);

    public function  getAllStatuses();

    public function deleteStatus($id);


    public function restoreStats($id);


    public function  forceDeleteStatus($id);
}
