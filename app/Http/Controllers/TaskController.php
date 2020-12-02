<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Task;

class TaskController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function views(){
        $tasks = Task::orderByDesc('created_at','asc')->get();
        return view('home')->with(compact('tasks'));
    }

    public function create(Request $request){
        $rules = [
            'name' => 'required|max:255'
        ];
        $messages = [
            'name.required' => 'Bắt buộc nhập tên Task',
            'name.max' => 'Tối đa 255 kí tự thôi anh zai!'
        ];
        $this->validate($request,$rules,$messages);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $task = new Task();
            $task->user_id = Auth::user()->id;
            $task->name = $data['name'];
            $task->save();
            Session::flash('success_message','Thêm task thành công!');
        }
        return back();
    }

    public function update(Request $request,$id){
        $task = Task::where('id',$id)->first();
        if (Auth::user()->can('update',$task)) {
            if ($request->isMethod('post')) {
                $data = $request->all();
                Task::where('id',$id)->update(['name'=>$data['nameEdit']]);
                Session::flash('success_message','Update task thành công!');
            }
            return back();
        }else{
            Session::flash('error_message','Bạn không có quyền cập nhật task!');
        }
        return back();
    }

    public function delete($id){
        $task = Task::where('id',$id)->first();
        if(Auth::user()->can('delete',$task)){
            Task::where('id',$id)->delete();
            Session::flash('success_message','Xóa task thành cong!');
        }else {
            Session::flash('error_message', 'Không có quyền xóa task!');
        }
        return back();
    }
}
