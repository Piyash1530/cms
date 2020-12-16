<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\DbController;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact',[PostsController::class, 'contact']);


/*
|--------------------------------------------------------------------------
| Databse Raw SQL Quaries INSERT , UPDATE , VIEW
|--------------------------------------------------------------------------
*/

Route::get('/insert',function(){

    DB::insert('insert into posts(title,body) values(?,?)',['PHP second Inserion','PHP Laravel is awesome with Piyash ']);

});

Route::get('/read',function(){

    $results = DB::select('select * from posts where id =?',[1]);

    foreach($results as $posts){
        return var_dump($results);
    }
    
});

Route::get('/update',function(){

    $updated = DB::update('update posts set title="updated title" where id = ?',[1]);

    return  $updated;

});

Route::get('/delete',function(){

    $deleted = DB::delete('delete from posts where id = ?',[1]);
    if($deleted===1){
        echo"Yeah we have deletd your data";
    }
    else{
        echo"we are unable to delete";
    }
});


/*
|--------------------------------------------------------------------------
| ELOQUENT 
|--------------------------------------------------------------------------
*/

Route::get('/find',function(){

    $posts = Post::all();

    foreach($posts as $post){

        return $post->title;
    }

});

Route::get('/findwhere',function(){

    $posts = Post::where('id',1)->orderBy('id','desc')->take(1)->get();
    return $posts;



});

Route::get('/findmore',function(){

    // $posts = POST::findOrFail(2);

    // return $posts;

    $posts = POST::where('users_count','<','50')->firstOrFail();
    
    return $posts;


});

Route::get('/basicinsert',function(){

    $posts = new Post;

    $posts->title ='New Eloquent Title Insert';
    $posts->body = 'now eloqunet is really cool,look at this';
    $posts->save();


});

Route::get('/basicinsertupdate',function(){

    $posts = Post::find(2);

    $posts->title ='New Eloquent Title Insert 2 ';
    $posts->body = 'now eloqunet is really cool,look at this 2';
    $posts->save();


});


Route::get('/create',function(){

    Post::create(['title'=>'The create method','body'=>'Wow I am learning a lot of php']);



});

Route::get('/updated',function(){

    Post::where('id',2)->where('is_admin',0)->update(['title'=>'New PHP tile','body'=>'I love everyone']);

});

Route::get('/deleted',function(){
    $posts=Post::find(1);

    $posts->delete();

});
Route::get('/deleted2',function(){
    Post::destroy([2,4]);
    //Post::where('is_admin',0)->delete();

});
Route::get('/softdelete',function(){
    Post::find(5)->delete();
   

});
Route::get('/softdelete',function(){
    // $posts = Post::find(5);
    // return $posts;

   $post=  Post::withTrashed()->where('id',5)->get();
   return $post;

});
Route::get('/softdelete',function(){
    // $posts = Post::find(5);
    // return $posts;

   $post=  Post::onlyTrashed()->where('id',5)->get();
   return $post;

});

Route::get('/restore',function(){
    // $posts = Post::find(5);
    // return $posts;

   $post=  Post::withTrashed()->where('id',5)->restore();
  

});