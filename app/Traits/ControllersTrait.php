<?php

namespace App\Traits;

trait ControllersTrait
{
    public function dataWithPagination($model)
    {
        return response()->json([
            'pagination' => [
                'total'         => $model->total(), // total de registros
                'current_page'  => $model->currentPage(), // pagina actual
                'per_page'      => $model->perPage(), // por pagina
                'last_page'     => $model->lastPage(), // ultima pagina
                'from'          => $model->firstItem(), // desde - primer elemento
                'to'            => $model->lastItem() // hasta - ultimo elemento
            ],
            'data' => $model->all(),
        ]);
    }
}