<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Models\Maulid;
use App\Models\MaulidContent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class MaulidController extends Controller
{
  protected $maulid, $maulidContent;

  public function __construct(Maulid $maulid, MaulidContent $maulidContent)
  {
    $this->maulid = $maulid;
    $this->maulidContent = $maulidContent;
  }

  public function index(Request $request)
  {
    $query = $this->maulid->query();

    if ($request->has('search')) {
      $query->where(function ($query) use ($request) {
        $query->where("name", "LIKE", "%$request->search%");
      });
    }

    if ($request->has('maulid_id')) {
      $query->where('id', $request->maulid_id);
    }

    $query->where('status', 1);

    $countmaulid = $query->count();
    $maulids = $query->paginate($request->per_page);

    if ($request->has('maulid_id')) {
      return $this->detail($maulids->items());
    }

    return MessageFixer::render(
      code: $countmaulid > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
      message: $countmaulid > 0 ? null : "Maulid no available.",
      data: $countmaulid > 0 ? $maulids->items() : null,
      paginate: ($maulids instanceof LengthAwarePaginator) && $countmaulid > 0  ? [
        "current_page" => $maulids->currentPage(),
        "last_page" => $maulids->lastPage(),
        "total" => $maulids->total(),
        "from" => $maulids->firstItem(),
        "to" => $maulids->lastItem(),
      ] : null
    );
  }

  protected function detail($maulid)
  {
    $data = null;

    if (count($maulid) > 0) {
      $data = $maulid[0];

      $data->contents = $this->maulidContent->whereMaulidId($data->id)->get();
    }

    return MessageFixer::render(
      code: count($maulid) > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
      message: count($maulid) > 0 ? null : "Maulid no available.",
      data: $data
    );
  }
}
