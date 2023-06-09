<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console; 
use Exception;


class MyModel extends Model
{
    use HasFactory;


    // 心得
    function feelIndex(){
        $datas = DB::table('Feel_list')
                ->leftJoin('users', 'Feel_list.uid', '=', 'users.id')
                ->select('*', DB::raw('Date(Feel_list.createtime) as date'))
                ->where('state','=','1')
                ->orderByDesc('Feel_list.createtime')
                ->paginate(10);
        return $datas;
    }
    function feelnew($ftid){
        $datas = DB::table('Feel_list')
                ->leftJoin('users', 'Feel_list.uid', '=', 'users.id')
                ->select('*', DB::raw('Date(Feel_list.createtime) as date'))
                ->where('state','=','1')
                ->where('fid','<>',$ftid)
                ->orderByDesc('Feel_list.createtime')
                ->paginate(10);
        return $datas;
    }

    function FeIsRed($ftid,$uid){
        $isRed = DB::select("select * from Feel_saved where fid = ? and uid =?",[$ftid,$uid]);
        return $isRed;
    }

    function UserPic($uid){
        $userPic = DB::select("SELECT * FROM users WHERE id = ?",[$uid]);
        return $userPic;
    }

    function feelSearch($search){
        $outputs = DB::table('Feel_list')
        ->leftJoin('users', 'Feel_list.uid', '=', 'users.id')
        ->select('*', DB::raw('Date(Feel_list.createtime) as date'))
        ->where('title', 'REGEXP', $search)
        ->where('state','=','1')
        ->orderByDesc('Feel_list.createtime')
        ->paginate(10);
        // $outputs = DB::select("SELECT * FROM `Feel_list` left join users on Feel_list.uid = users.id WHERE title REGEXP ?",[$search]);
        return $outputs;
    }

    
    function feelNews(){
        $datas = DB::select("select *, Date(createtime) as date from Feel_list left join users on Feel_list.uid = users.id where state = 1 order by Feel_list.createtime desc LIMIT 9");
        return $datas;
    }
    function feelDetail($id){
        $datas = DB::select("select *, Date(createtime) as date from Feel_list left join users on Feel_list.uid = users.id where Feel_list.fid = ?",[$id]);
        return $datas;
    }
    function feelComment($id){
        $comments = DB::select("select fcid,Feel_comment.uid,Feel_comment.content as content,upicture,name,title,Feel_comment.createtime from Feel_comment left join Feel_list on Feel_comment.fid = Feel_list.fid left join users on Feel_comment.uid = users.id where Feel_comment.fid = ?",[$id]);
        return $comments;
    }


    function feelComPN($uid){
        $userDatas = DB::select("select name, upicture from users where id = ?",[$uid]);
        return $userDatas;
    }

    function feelCom($ftid,$uid,$feelcom){
        DB::insert("INSERT INTO `Feel_comment` SET fid = ?, uid = ?, content = ? ",[$ftid,$uid,$feelcom]);
        $answer = "ok";
        return $answer;
    }

    function feelComEdit($fcid,$feelcom){
        DB::update("UPDATE `Feel_comment` SET content = ? WHERE fcid = ?",[$feelcom,$fcid]);
        $answer = "ok";
        return $answer;
    }

    function feelComDelect($fcid){
        DB::delete("DELETE FROM `Feel_comment` WHERE fcid = ?",[$fcid]);
        $answer = "ok";
        return $answer;
    }

    function feelMes($uid,$title,$content,$src,$state){      
        try {
            DB::insert("INSERT INTO Feel_list SET uid = ?, title = ?, content = ?,fpicture = ? ,state = ?",[$uid, $title, $content,$src,$state]);
            $answer = 1;
        } catch(Exception $e) {
            $answer = 0;
            $errorMessage = $e->getMessage();
            // 在這裡可以透過 $errorMessage 變數取得錯誤訊息，進行相關的處理。
        }
        return $answer;
    }

    function feelSaved($uid,$ftid){
        DB::insert("INSERT INTO `Feel_Saved` SET uid = ?, fid = ?",[$uid,$ftid]);
        $answer = "ok";
        return $answer;
    }

    function feelUnsaved($uid,$ftid){
        DB::delete("Delete from `Feel_Saved` WHERE uid = ? and fid = ?",[$uid,$ftid]);
        $answer = "ok";
        return $answer;
    }


    
    // 論壇

    function question(){
        $questions = DB::table('Forum_list')
                ->leftJoin('users', 'Forum_list.uid', '=', 'users.id')
                ->select('fpicture', 'foid', 'title', 'name', 'Forum_list.createtime as createtime')
                ->where('Forum_list.sfid', '=', 1)
                ->where('state','=','1')
                ->orderByDesc('Forum_list.createtime')
                ->paginate(10);

        return $questions;
    }

    function forumQSearch($search){
        $Qoutputs  = DB::table('Forum_list')
        ->leftJoin('users', 'Forum_list.uid', '=', 'users.id')
        ->select('fpicture', 'foid', 'title', 'name', DB::raw('Date(Forum_list.createtime) as date'))
        ->where('Forum_list.sfid', '=', 1)
        ->where('state','=','1')
        ->where('title', 'REGEXP', $search)
        ->orderByDesc('Forum_list.createtime')
        ->paginate(6);
        return $Qoutputs;
    }

    // function group(){
    //     $groups = DB::select("select fpicture,foid,title,name,Forum_list.createtime as createtime from Forum_list left join users on Forum_list.uid = users.id where Forum_list.sfid = 2 order by Forum_list.createtime");
    //     return $groups;
    // }
    function group(){
        $groups= DB::table('Forum_list')
        ->leftJoin('users', 'Forum_list.uid', '=', 'users.id')
        ->select('fpicture', 'foid', 'title', 'name', 'Forum_list.createtime as createtime')
        ->where('Forum_list.sfid', '=', 2)
        ->where('state','=','1')
        ->orderByDesc('Forum_list.createtime')
        ->paginate(10);
        return $groups;
    }

    function forumGSearch($search){
        $Goutputs  = DB::table('Forum_list')
        ->leftJoin('users', 'Forum_list.uid', '=', 'users.id')
        ->select('fpicture', 'foid', 'title', 'name', DB::raw('Date(Forum_list.createtime) as date'))
        ->where('Forum_list.sfid', '=', 2)
        ->where('state','=','1')
        ->where('title', 'REGEXP', $search)
        ->orderByDesc('Forum_list.createtime')
        ->paginate(6);
        return $Goutputs;
    }

    // function hater(){
    //     $haters = DB::select("select fpicture,foid,title,name,Forum_list.createtime as createtime from Forum_list left join users on Forum_list.uid = users.id where Forum_list.sfid = 3 order by Forum_list.createtime");
    //     return $haters;
    // }
    function hater(){
        $haters= DB::table('Forum_list')
        ->leftJoin('users', 'Forum_list.uid', '=', 'users.id')
        ->select('fpicture', 'foid', 'title', 'name', 'Forum_list.createtime as createtime')
        ->where('Forum_list.sfid', '=', 3)
        ->where('state','=','1')
        ->orderByDesc('Forum_list.createtime')
        ->paginate(10);
        return $haters;
    }

    function forumHSearch($search){
        $Houtputs  = DB::table('Forum_list')
        ->leftJoin('users', 'Forum_list.uid', '=', 'users.id')
        ->select('fpicture', 'foid', 'title', 'name', DB::raw('Date(Forum_list.createtime) as date'))
        ->where('Forum_list.sfid', '=', 3)
        ->where('title', 'REGEXP', $search)
        ->where('state','=','1')
        ->orderByDesc('Forum_list.createtime')
        ->paginate(6);
        return $Houtputs;
    }

    function forumDetail($sid,$foid){
        $datas = DB::select("select uid, fpicture, name, title, Date(Forum_list.createtime) as date, upicture, Forum_list.content as content from Forum_list left join users on Forum_list.uid = users.id where Forum_list.sfid = ? and Forum_list.foid = ? ",[$sid, $foid]);
        return $datas;
    }

    function FoIsRed($ftid,$uid){
        $isRed = DB::select("select * from Forum_saved where foid = ? and uid =?",[$ftid,$uid]);
        return $isRed;
    }

    function FCquestion($foid){
        $FCquestions = DB::select("SELECT * FROM Forum_comment left join users on Forum_comment.uid = users.id where foid = ?",[$foid]);
        return $FCquestions;
    }

    function forumNew($sid,$foid){
        $forumNews = DB::select("select *, Date(createtime) as date from Forum_list left join users on Forum_list.uid = users.id where state = 1 and Forum_list.foid <> ? order by Forum_list.createtime DESC LIMIT 10",[$foid]);
        return $forumNews;
    }

    function forumNew2(){
        // $forumNew2s = DB::select("select foid,title,name from Forum_list left join users on Forum_list.uid = users.id order by Forum_list.createtime");
        $forumNew2s = DB::select("select *, Date(createtime) as date from Forum_list left join users on Forum_list.uid = users.id where state = 1 order by Forum_list.createtime DESC LIMIT 9");
        return $forumNew2s;
    }
    
    function forumCom($uid,$sfid,$foid,$forumcom){
        DB::insert("INSERT INTO `Forum_comment` SET uid = ?, sfid = ?, foid = ?, content = ?",[$uid,$sfid,$foid,$forumcom]);
        $answer = "ok";
        return $answer;
    }

    function forumComEdit($focid,$forumcom){
        DB::update("UPDATE `Forum_comment` SET content = ? WHERE focid = ?",[$forumcom,$focid]);
        $answer = "ok";
        return $answer;
    }

    function forumComDelect($focid){
        DB::delete("DELETE FROM `Forum_comment` WHERE focid = ?",[$focid]);
        $answer = "ok";
        return $answer;
    }

    function forumSaved($uid,$ftid){
        DB::insert("INSERT INTO `Forum_Saved` SET uid = ?, foid = ?",[$uid,$ftid]);
        $answer = "ok";
        return $answer;
    }
    
    function forumUnsaved($uid,$ftid){
        DB::delete("Delete from `Forum_Saved` WHERE uid = ? and foid = ?",[$uid,$ftid]);
        $answer = "ok";
        return $answer;
    }
    


    function forumMes($sfid,$uid,$title,$content,$src,$state){
        // DB::insert("INSERT INTO Forum_list SET sfid = ?, uid = ?, title = ?, content = ?, fpicture = ?, state = ?",[$sfid, $uid, $title, $content, $pic, $state]);
        // $answer = "ok";
        // return $answer;  
        try {
            DB::insert("INSERT INTO Forum_list SET sfid = ?, uid = ?, title = ?, content = ?, fpicture = ?, state = ?",[$sfid, $uid, $title, $content, $src, $state]);
            $answer = 1;
        } catch(Exception $e) {
            $answer = 0;
            $errorMessage = $e->getMessage();
            // 在這裡可以透過 $errorMessage 變數取得錯誤訊息，進行相關的處理。
        }
        return $answer;
        
        
    }

    // function forumMesSaved($sfid,$uid,$title,$content,$pic){
    //     DB::insert("INSERT INTO forumMes_saved SET sfid = ?, uid = ?, title = ?, content = ?, fpicture = ?",[$sfid, $uid, $title, $content, $pic]);
    //     $answer = "ok";
    //     return $answer;     
    // }
    


    
}
