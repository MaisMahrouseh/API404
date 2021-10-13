<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\EditUserRequest;
use Illuminate\Http\Request;
use App\Http\myResponse\myResponse;


class TaskController extends Controller
{
    public $task;
    public $response;

    public function __construct(Task $task , myResponse $response)
    {
        $this->task = $task;
        $this->response = $response;
    }

    //إضافة مهمة من قبل المستخدم الحالي (الي مسجل دخول)
    public function create(AddTaskRequest $request)
    {
         $request->validated();
         $task =  auth()->user()->tasks()->save(new Task(request()->only('task', now())));
         if ($task)
           return  $this->response->returnSuccess('Added successfully' , 200);
         return $this->response->returnError('can not added' , 500);
    }
/*
    public function update(TaskUserEdit $request , $id)
    {
        $validated = $request->validated();
        if(auth()->user()->id == $request->user_id){
        $task =  Task::find($id);
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'task not found'
            ], 400);
        }
        $updated = $task->update($request->only('task','task_date'));
        if ($updated)
            return response()->json([
                'success' => true,
                'message' => 'Edited successfully'
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => ' can not be updated'
            ], 500);
        }
        else
        return response()->json([
            'success' => false,
            'message' => 'Only the user who added it can edit'
        ], 400);
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'task not found'
            ], 400);
        }
        $deleted = $task->delete();
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ],200);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'can not be deleted'
            ], 500);
        }
    }


    public function ShowAll()
    {
       $task =  Task::query()->with('user') ->get();
       $task -> makeHidden(['deleted_at' , 'created_at' ,'updated_at']);
      return response()->json([
        'success' => true,
        'data' => $task
    ],200);
    }*/
}
