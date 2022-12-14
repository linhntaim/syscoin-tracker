<?php

namespace App\Support\Database\Concerns;

use Illuminate\Support\Facades\DB;

trait DatabaseTransaction
{
    protected static array $dbTransactions = [];

    protected function transactionStart(?string $name = null): void
    {
        if (is_null($name)) {
            $name = config('database.default');
        }
        self::$dbTransactions[] = $name;
        DB::connection($name)->beginTransaction();
    }

    protected function transactionComplete($all = false): void
    {
        if ($all) {
            while ($name = array_pop(self::$dbTransactions)) {
                DB::connection($name)->commit();
            }
        }
        elseif ($name = array_pop(self::$dbTransactions)) {
            DB::connection($name)->commit();
        }
    }

    protected function transactionAbort($all = false): void
    {
        if ($all) {
            while ($name = array_pop(self::$dbTransactions)) {
                DB::connection($name)->rollBack();
            }
        }
        elseif ($name = array_pop(self::$dbTransactions)) {
            DB::connection($name)->rollBack();
        }
    }
}
