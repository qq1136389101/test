<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function($sql, $bindings, $time){
            $time = date('Y-m-d', time());
            $sql = str_replace(array('%', '?'), array('%%', '%s'), $sql);
            $sql = vsprintf($sql, $bindings);
            //记录sql, 存放在根目录sqls文件夹中
            if(!file_exists('sqls/'))
                mkdir('sqls/', 0777, true);
            file_put_contents('sqls/'.$time.'.sql', '['.date('Y-m-d H:i:s').']'.$sql."\r\n", FILE_APPEND);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
