<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Models\Doa;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DoaController extends Controller
{
  protected $doa;

  public function __construct(Doa $doa)
  {
    $this->doa = $doa;
  }

  public function index(Request $request)
  {
    $query = $this->doa->query();

    if ($request->has('search')) {
      $query->where(function ($query) use ($request) {
        $query->where("title", "LIKE", "%$request->search%");
      });
    }

    if ($request->has('doa_id')) {
      $query->where('id', $request->doa_id);
    }

    if ($request->has('category_id')) {
      $query->where('category_id', $request->category_id);
    }

    $countdoa = $query->count();
    $doa = $query->paginate($request->per_page);

    if ($request->has('doa_id')) {
      return $this->detail($doa->items());
    }

    return MessageFixer::render(
      code: $countdoa > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
      message: $countdoa > 0 ? null : "doa no available.",
      data: $countdoa > 0 ? $doa->items() : null,
      paginate: ($doa instanceof LengthAwarePaginator) && $countdoa > 0  ? [
        "current_page" => $doa->currentPage(),
        "last_page" => $doa->lastPage(),
        "total" => $doa->total(),
        "from" => $doa->firstItem(),
        "to" => $doa->lastItem(),
      ] : null
    );
  }

  protected function detail($doa)
  {
    return MessageFixer::render(
      code: count($doa) > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
      message: count($doa) > 0 ? null : "doa no available.",
      data: count($doa) > 0 ? $doa[0] : null
    );
  }
}
