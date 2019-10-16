<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        td {
            text-align: center;
        }

        .box {
            width: 250px;
            padding: 20px 20px;
            border: 1px solid #ccc;
            border-radius: 9px;
            position: absolute;
            top: 30%;
            left: 40%;
            background: #fff;
        }

        .box-bg {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            background: rgba(0,0,0,0.3);
            display: none;
        }

        .pagination{
            list-style: none;
            overflow: hidden;
            padding: 0;
        }

        .pagination > li {
            float: left;
            margin-left: 80px;
        }
    </style>
</head>
<body>
    <h2>用户列表</h2>

    <table width="40%" cellpadding="10" cellspacing="0" border="1">
        <tr>
            <td>id</td>
            <td>名称</td>
            <td>邮箱</td>
            <td>操作</td>
        </tr>
        @for($i = 0;$i < count($users);$i++)
            <tr>
                <td class="id">{{$users[$i]->id}}</td>
                <td class="name">{{$users[$i]->name}}</td>
                <td class="email">{{$users[$i]->email}}</td>
                <td>
                    <button class="del">删除</button>
                    <button class="edit">编辑</button>
                </td>
            </tr>
        @endfor
    </table>
    {{ $users->links() }}
    <a href="/user/add">添加</a>

    <div class="box-bg">
        <div class="box">
            <p>用户编辑</p>
            <input type="hidden" class="inp-id">
            名称:<input type="text" class="inp-name"><br>
            邮箱:<input type="text" class="inp-email"><br>
            <button class="toEdit">编辑</button>
        </div>
    </div>

    <script src="{{ URL::asset('/') }}js/jquery-3.3.1.js"></script>
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
</body>
</html>
