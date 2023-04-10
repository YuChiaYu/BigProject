<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyModel;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


class FeelController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new MyModel;
    }
    public function feelIndex()
    {
        $datas = $this->model->feelIndex();
        return view('feelIndex', ['datas' => $datas]);
    }

    public function feelDetail(Request $request)
    {
        $ftid = $request->id;
        $article = $this->model->feelDetail($ftid);
        $datas = $this->model->feelIndex();
        $comments = $this->model->feelComment($ftid);
        $uid = Auth::id();
        $userDatas = $this->model->feelComPN($uid);
        return view('feelDetail', [
            'article' => $article,
            'datas' => $datas,
            'comments' => $comments,
            'userDatas' => $userDatas,
            'uid' => $uid,
            'ftid' => $ftid
        ]);
    }

    public function feelCom(Request $request)
    {
        $uid = $request->uid;
        $ftid = $request->ftid;
        $feelcom = $request->feelcom;
        $this->model->feelCom($ftid, $uid, $feelcom);

        return redirect("/feelDetail/{$ftid}");
    }

    public function feelMes(Request $request)
    {
        $uid = $request->uid;
        $title = $request->title;
        $content = $request->content;

        // 從請求中獲取文件實例
        $file = $request->file('pic');
        // 獲取文件的二進制內容
        $pic = $file->get();

        $this->model->feelMes($uid, $title, $content, $pic);
        return redirect("/feelIndex");
    }

}