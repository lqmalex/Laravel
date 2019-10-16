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
                        <button class="del btn btn-danger">删除</button>
                        <button class="edit btn btn-info">编辑</button>
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
@endsection
@section('JavaScript')
    <script>
        $('.del').click(function () {
            let id = $(this).parents('tr').children('.id').html();
            let dis = $(this).parents('tr');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"DELETE",
                url:"/del/"+id,
                data:{},
                dataType:'json',
                success: function (data) {
                    if (data.type) {
                        alert(data.info);
                        $(dis).css('display','none');
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
