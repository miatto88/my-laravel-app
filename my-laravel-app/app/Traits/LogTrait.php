<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\User;
use Log;

trait LogTrait
{
    /**
     * 開始ログ
     */
    public function logStart()
    {
        $caller = $this->fetchCaller();
        Log::info(" [{$caller['class']}][{$caller['function']}] start.");
    }

    /**
     * 終了ログ
     */
    public function logEnd()
    {
        $caller = $this->fetchCaller();
        Log::info(" [{$caller['class']}][{$caller['function']}] end.");
    }

    /**
     * 呼び出し元情報(クラス&メソッド)を取得する
     * @return 呼び出し元情報
     */
    private function fetchCaller(): array
    {
        $dbg = debug_backtrace();

        return [
            'class'    => $dbg[2]['class'],
            'function' => $dbg[2]['function'],
        ];
    }

    /**
     * エラーログを出力する
     */
    public function errorLog($model, $request)
    {
        $caller = $this->fetchCaller();

        $errorLog = sprintf( '[%s][%s][%s] %s params: %s',
            $caller['class'],
            $caller['function'],
            'error',
            "failed to {$caller['function']} {$model}.",
            // Auth::user()->id,
            json_encode($request)
        );
        Log::error($errorLog);
    }
}