<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Models\DoaCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DoaCategoryController extends Controller
{
    protected $category;

    public function __construct(DoaCategory $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $query = $this->category->query();

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where("title", "LIKE", "%$request->search%");
            });
        }

        if ($request->has('category_id')) {
            $query->where('id', $request->category_id);
        }

        $countcategory = $query->count();
        $categories = $query->paginate($request->per_page);

        if ($request->has('category_id')) {
            return $this->detail($categories->items());
        }

        return MessageFixer::render(
            code: $countcategory > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
            message: $countcategory > 0 ? null : "Category no available.",
            data: $countcategory > 0 ? $categories->items() : null,
            paginate: ($categories instanceof LengthAwarePaginator) && $countcategory > 0  ? [
                "current_page" => $categories->currentPage(),
                "last_page" => $categories->lastPage(),
                "total" => $categories->total(),
                "from" => $categories->firstItem(),
                "to" => $categories->lastItem(),
            ] : null
        );
    }

    protected function detail($category)
    {
        return MessageFixer::render(
            code: count($category) > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
            message: count($category) > 0 ? null : "Category no available.",
            data: count($category) > 0 ? $category[0] : null
        );
    }
}
