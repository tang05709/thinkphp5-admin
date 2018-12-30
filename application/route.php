<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
*/

use think\Route;
Route::resource('backend/configs', 'backend/Configs');
Route::resource('backend/friend_links', 'backend/FriendLinks');
Route::resource('backend/admins', 'backend/Admins');
Route::resource('backend/feedbacks', 'backend/Feedbacks');
Route::get('backend/get_captcha', 'backend/Captcha/get_captcha');

Route::resource('backend/articles', 'backend/Articles');
Route::post('backend/articles/batch_delete', 'backend/Articles/batch_delete');
Route::post('backend/articles/change_taxon', 'backend/Articles/change_taxon');

Route::resource('backend/products', 'backend/Products');
Route::post('backend/products/batch_delete', 'backend/Products/batch_delete');
Route::post('backend/products/change_taxon', 'backend/Products/change_taxon');

Route::resource('backend/photos', 'backend/Photos');
Route::post('backend/photos/batch_delete', 'backend/Photos/batch_delete');
Route::post('backend/photos/change_taxon', 'backend/Photos/change_taxon');

Route::resource('backend/taxons', 'backend/Taxons');
Route::get('backend/pages', 'backend/Pages/index');
Route::put('backend/pages/:id', 'backend/Pages/update');

Route::get('backend/index', 'backend/Index/index');
Route::post('backend/get_move_module', 'backend/Index/get_move_module');

Route::post('backend/upload', 'backend/Upload/upload');
Route::any('backend/detail_upload', 'backend/Upload/detail_upload');
Route::post('backend/del_upload', 'backend/Upload/del_upload');

Route::get('backend/login', 'backend/Auth/login');
Route::post('backend/loginin', 'backend/Auth/loginin');
Route::get('backend/loginout', 'backend/Auth/loginout');
