@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Task</div>
                    <form action="{{ url('task/create') }}" method="POST">@csrf
                        <div class="card-body">
                            <!-- Task Name -->
                            <div class="form-group">
                                <label for="task-name" class="col-sm-3 control-label">Task</label>

                                <div class="col-sm-6">
                                    <input type="text" name="name" id="task-name" class="form-control">
                                </div>
                            </div>

                            <!-- Add Task Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-success">
                                        Add Task
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        {{-- Validation --}}
        {{-- Alert message --}}
        <div class="col-md-8" style="margin-top: 5px;">
            @if (count($errors) > 0)
                <!-- Form Error List -->
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Thêm task thất bại!</strong>

                    <br><br>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ Session::get('error_message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            @endif
        </div>

        {{-- Current Task --}}
        <diV class="col-md-8" style="margin-top: 20px;">
            <div class="card">
                <div class="card-header">Current Tasks</div>
                <div class="card-body">
                    <div class="panel-body">
                        <table class="table table-striped task-table">

                            <!-- Table Headings -->
                            <thead>
                                <th>Task</th>
                                <th>&nbsp;</th>
                            </thead>

                            <!-- Table Body -->
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <!-- Task Name -->
                                        <td class="table-text">
                                            <div>{{ $task->name }}</div>
                                        </td>
                                        <td>
                                        @can('delete',$task)
                                            <a href="{{ url('task/delete/'.$task->id) }}" type="button" class="btn btn-danger"> Delete</a>
                                        @endcan
                                        @can('update',$task)
                                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataTask{{$task->id}}"> Update</a>
                                        @endcan
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal" id="dataTask{{$task->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Update Task</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                        <form action="{{ url('task/update/'.$task->id) }}" method="POST">@csrf
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="task-name" class="col-sm-3 control-label">Task</label>
                                                    <div class="col-sm-12">
                                                    <input type="text" name="nameEdit" id="task-name" class="form-control" value="{{$task->name}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- The Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </diV>
    </div>
</div>
@endsection
