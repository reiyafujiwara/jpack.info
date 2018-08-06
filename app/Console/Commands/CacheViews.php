<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class CacheViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '利用するビューのキャッシュ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 全てのキャッシュを削除
        Cache::flush();

        /* 再キャッシュ */
        
        // トップページ
        $top_page = View::make('pages.index')->render();
        Cache::forever('views.pages.index', $top_page);

        // 料金ページ
        $price_page = View::make('pages.price')->render();
        Cache::forever('views.pages.price', $price_page);

        // 利用規約
        $term_page = View::make('pages.term')->render();
        Cache::forever('views.pages.term', $term_page);

        // 特定商取引法
        $commerce_page = View::make('pages.commerce')->render();
        Cache::forever('views.pages.commerce', $commerce_page);

    }
}
