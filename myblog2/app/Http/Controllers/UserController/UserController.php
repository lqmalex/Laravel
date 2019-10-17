<?php

namespace App\Http\Controllers\UserController;

use App\User;
use App\UserModel as UserModel;
use App\Http\Controllers\Controller;
use Cassandra\Session;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogPost as Store;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;
use Validator;

class UserController extends Controller{
    /**
     * 主页面
     * @return
     */
    public function select(Request $request) {
        session()->forget('searchName');
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
        session()->put('searchName',$request->name);
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
        if (!$request->isMethod('get')) {
            $stroe = new Store();
            $request->validate($stroe->rules2($request->id),$stroe->messages());

            /*
            PHP 闭包 ORM and or 优先级
            $query = new UserModel();
            $sql2 = $query->where('id','!=',$request->id)->where(function ($query) use ($request){
                 $query->where('name','=',$request->name)->orWhere('email','=',$request->email);
            })->get();

            if (count($sql2) != 0) {
                 return view('edit',['name'=>session('user'),'id'=>$request->id,'uname'=>$request->name,'email'=>$request->email]);
            }
            */

            $sql = (new UserModel())::where('id','=',$request->id)->update(['name'=>$request->name,'email'=>$request->email]);

            if ($sql) {
                if (!empty(session()->has('userEdit'))) {
                    session()->forget('user');
                    session()->forget('userEdit');
                    return redirect('/login');
                } else {
                    return redirect('/'.'?page='.$request->page);
                }
            } else {
                session()->put('mes','未修改');
                return view('edit',['name'=>session('user'),'id'=>$request->id,'uname'=>$request->name,'email'=>$request->email,'page'=>$request->page]);
            }
        } else {
            if (substr(url()->previous(),strripos(url()->previous(),'?')+1,4) != 'page') {
                $page = 1;
            } else {
                $page = substr(url()->previous(),strripos(url()->previous(),'?')+6);
            }

            if ($request->name == session('user')) {
                session()->put('userEdit',true);
            }

            return view('edit',['name'=>session('user'),'id'=>$request->id,'uname'=>$request->name,'email'=>$request->email,'page'=>$page]);
        }
    }

    /**
     * 用户添加
     * @param Store $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userAdd(Store $request) {
        session()->forget('searchName');
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
        $sql = UserModel::where(['name'=>$request->name,'email'=>$request->email])->first();

        if ($sql != null) {
            if ($request->pass == decrypt($sql->pass)) {
                session()->put('user',$request->name);
                return redirect('/');
            } else {
                return redirect('/login')->with('tip', '密码错误');
            }
        } else {
            return redirect('/login')->with('tip', '请查看用户名和邮箱是否正确');
        }
    }

    /**
     * 退出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function out() {
        session()->forget('searchName');
        session()->forget('user');
        return redirect('/');
    }
}
