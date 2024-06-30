<?php

namespace App\Utils;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class StructUtil
{
    public static function paginate(
        Collection|array $items,
        int $limit = 20,
        $page = null,
        array $options = []
    ): LengthAwarePaginator
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		$options = $options === [] ? ['path' => Request::url()] : $options;
		$cnt = $items->count();

        if($page > 1 && $cnt < ($page * $limit) - $limit){
            $page = 1;
        }

        return new LengthAwarePaginator(
            $items->forPage($page, $limit),
            $cnt,
            $limit,
            $page,
            $options
        );
    }
}