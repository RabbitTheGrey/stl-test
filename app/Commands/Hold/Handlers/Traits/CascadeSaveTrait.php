<?php

declare(strict_types=1);

namespace App\Commands\Hold\Handlers\Traits;

use Exception;
use Illuminate\Support\Facades\DB;

trait CascadeSaveTrait
{
    /**
     * Транзакционное сохранение изменений в бд
     * 
     * @return void
     * @throws Exception
     */
    private function save(): void
    {
        DB::beginTransaction();

        try {
            $this->hold->save();
            $this->slot->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
    }
}
