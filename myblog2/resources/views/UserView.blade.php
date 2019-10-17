@extends('User')
@section('active')
    <li class="active"><a href="/"><i class="fa fa-link"></i> <span>用户表</span></a></li>
    <li><a href="/user/add"><i class="fa fa-link"></i> <span>添加用户</span></a></li>
@endsection
@section('section')
    <div class="box-body">
        <table id="example2" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>id</th>
                <th>名称</th>
                <th>邮箱</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @for($i = 0;$i < count($users);$i++)
                <tr>
                    <td class="id">{{$users[$i]->id}}</td>
                    <td class="name">{{$users[$i]->name}}</td>
                    <td class="email">{{$users[$i]->email}}</td>
                    <td>
                        @if($users[$i]->name != session('user') )
                        <button class="delete btn btn-danger" data-toggle="modal" data-target="#myModal">删除</button>
                        @endif
                        <a href="/user/edit?id={{$users[$i]->id}}&name={{$users[$i]->name}}&email={{$users[$i]->email}}" class="btn btn-info">编辑</a>
                    </td>
                </tr>
            @endfor
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        @if($search == '')
            {{$users->links()}}
        @else
            {{ $users->appends(['name'=>$search])->links() }}
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">确定删除?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary del" data-dismiss="modal">删除</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('JavaScript')
    <script>
        let DelId;
        let DelDis;
        $('.delete').click(function () {
           // console.log($(this));
            DelId = $(this).parents('tr').children('.id').html();
            DelDis = $(this).parents('tr');
        });
        $('.del').click(function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"DELETE",
                url:"/del/"+DelId,
                data:{},
                dataType:'json',
                success: function (data) {
                    if (data.type) {
                        alert(data.info);
                        $(DelDis).css('display','none');
                    } else {
                        alert(data.info);
                    }
                },
                error:function(err){
                    console.log("错误");
                }
            })
        });

        let id;
        let name;
        let email;
        $('.edit').click(function () {
            id = $(this).parents('tr').children('.id');
            name = $(this).parents('tr').children('.name');
            email = $(this).parents('tr').children('.email');

            $('.box-bg').css('display','block');
            $('.inp-name').val($(name[0]).html());
            $('.inp-email').val($(email[0]).html());
            $('.inp-id').val($(id[0]).html());
        })

        $('.toEdit').click(function () {
            let id = $('.inp-id').val();
            let nameVal = $('.inp-name').val();
            let emailVal = $('.inp-email').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/edit',
                data:{
                    'id':id,
                    'name':nameVal,
                    'email':emailVal
                },
                dataType:'json',
                success:function (data) {
                    if (data.type) {
                        name.html(nameVal);
                        email.html(emailVal);
                        $('.box-bg').css('display','none');
                        alert(data.info);
                    } else {
                        alert(data.info);
                    }
                },
                error:function (err) {
                    console.log('错误');
                }
            })
        })
    </script>
@endsection
