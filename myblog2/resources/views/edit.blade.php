@extends('User')
@section('active')
    <li><a href="/"><i class="fa fa-link"></i> <span>用户表</span></a></li>
    <li><a href="/user/add"><i class="fa fa-link"></i> <span>添加用户</span></a></li>
@endsection
@section('section')
    @if(!empty(session('mes')))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('mes') }}</li>
            </ul>
        </div>
        {{session()->forget('mes')}}
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-md-6">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">用户编辑</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="/user/edit" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="page" value="{{ $page }}">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>

                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{$uname}}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">邮箱</label>

                        <div class="col-sm-10">
                            <input type="email" name="email" value="{{$email}}" class="form-control" id="inputPassword3">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info btn-block">编辑</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
@endsection
