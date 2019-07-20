<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getJson($data = [], $error = null)
    {
        $object = [
            'status' => $error === null,
            'data' => $data,
        ];

        if ($error != null) {
            $object['errors'] = $error;
        }
        return $object;
    }

    public function getJsonPaginate($paginate)
    {
        $object = [
            'status' => true,
            'data' => [
                'items' => $paginate->items(),
                'meta' => [
                    'current_page' => (int) $paginate->currentPage(),
                    'last_page' => (int) $paginate->lastPage(),
                    'per_page' => (int) $paginate->perPage(),
                    'total' => (int) $paginate->total(),
                ],
            ],
        ];
        return $object;
    }
}
