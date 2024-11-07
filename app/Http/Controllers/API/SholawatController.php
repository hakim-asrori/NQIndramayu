<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Models\Sholawat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SholawatController extends Controller
{
    protected $sholawat;

    public function __construct(Sholawat $sholawat)
    {
        $this->sholawat = $sholawat;
    }

    public function index(Request $request)
    {
        $query = $this->sholawat->query();

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where("title", "LIKE", "%$request->search%");
                $query->orWhere("content", "LIKE", "%$request->search%");
            });
        }

        if ($request->has('sholawat_id')) {
            $query->where('id', $request->sholawat_id);
        }

        $query->where('status', 1);

        $countsholawat = $query->count();
        $sholawats = $query->paginate($request->per_page);

        if ($request->has('sholawat_id')) {
            return $this->detail($sholawats->items());
        }

        return MessageFixer::render(
            code: $countsholawat > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
            message: $countsholawat > 0 ? null : "Sholawat no available.",
            data: $countsholawat > 0 ? $sholawats->items() : null,
            paginate: ($sholawats instanceof LengthAwarePaginator) && $countsholawat > 0  ? [
                "current_page" => $sholawats->currentPage(),
                "last_page" => $sholawats->lastPage(),
                "total" => $sholawats->total(),
                "from" => $sholawats->firstItem(),
                "to" => $sholawats->lastItem(),
            ] : null
        );
    }

    protected function detail($sholawat)
    {
        return MessageFixer::render(
            code: count($sholawat) > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
            message: count($sholawat) > 0 ? null : "Sholawat no available.",
            data: count($sholawat) > 0 ? $sholawat[0] : null
        );
    }
}
