<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Throwable;

trait TransactionTraits
{
    /**
     * @throws \Throwable
     */
    protected function transaction(callable $callback, callable $error = null)
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            $result = $this->catchException($throwable, $error);
        }
        return $result;
    }

    /**
     * @throws \Throwable
     */
    protected function catchException(Throwable $throwable, $error)
    {
        if (is_callable($error)) {
            return $error($throwable);
        } else {
            if ($error) {
                return $error;
            }
            throw $throwable;
        }
    }
}
