<?php

namespace App\Http\Controllers\UserApp;

use App\User;
use App\UserModel as UserModel;
use App\Http\Controllers\Controller;
use Cassandra\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBlogPost as Store;
use Validator;

class UserApp extends Controller{
    /**
     * 主页面
     * @return
     */
    public function selete() {
        if (!empty(session()->has('user'))) {
            $sql = UserModel::Paginate(5);
            $name = session()->get('user');
            return view('UserView',['users'=>$sql,'search'=>'','name'=>$name]);
        } else {
            return redirect('/login');
        }
    }

    /**
     * 查询
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request) {
        $sql = UserModel::where('name','like','%'.$request->name.'%')->Paginate(5);
        $search = $request->name;

        return view('UserView',['users'=>$sql,'search'=>$search,'name'=>session('user')]);
    }

    /**
     * 删除
     * @param $id
     * @return false|string
     */
    public function del($id) {
        $sql = UserModel::destroy($id);

        if ($sql) {
            $info = [
                'type'=>true,
                'info'=>"删除成功",
            ];
            return json_encode($info);
        } else {
            $info = [
                'type'=>false,
                'info'=>"删除失败",
            ];
            return json_encode($info);
        }
    }

    /**
     * 修改
     * @param Request $request
     * @return false|string
     */
    public function edit(Request $request) {
        $sql = UserModel::where('id','=',$request->all()['id'])->update(['name'=>$request->all()['name'],'email'=>$request->all()['email']]);

        if ($sql) {
            $info = [
                'type'=>true,
                'info'=>"修改成功"
            ];
            return json_encode($info);
        } else {
            $info = [
                'type'=>false,
                'info'=>"修改失败",
            ];
            return json_encode($info);
        }
    }

    /**
     * 用户添加
     * @param Store $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userAdd(Store $request) {
        $UserModel = new UserModel();
        $UserModel->name = $request->name;
        $UserModel->email = $request->email;
        $UserModel->pass = encrypt($request->pass);

        $sql = $UserModel->save();

        if ($sql) {
            return redirect('/');
        } else {
            echo "添加失败";
        }
    }

    /**
     * 注册
     * @param Store $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userReg(Store $request) {
        $UserMode = new UserModel();
        $UserMode->name = $request->name;
        $UserMode->email = $request->email;
        $UserMode->pass = encrypt($request->pass);

        $sql = $UserMode->save();

        if ($sql) {
            return redirect('/login');
        }
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userLogin(Request $request) {
        $sql = UserModel::where(['name'=>$request->name,'email'=>$request->email])->get();

        if (count($sql) != 0) {
            foreach ($sql as $key=>$val) {
                $pass = $val->pass;
                $pwd = decrypt($pass);
                if ($pwd == $request->pass) {
                    session()->put('user',$request->name);
                    return redirect('/');
                } else {
                    return redirect('/login')->with('tip', '密码错误');
                }
            }
        } else {
            return redirect('/login')->with('tip', '请查看用户名和邮箱是否正确');
        }
    }
}
