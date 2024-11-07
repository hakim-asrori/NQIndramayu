<?php

namespace App\Http\Controllers\API;

use App\Facades\MessageFixer;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    protected $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function index(Request $request)
    {
        $query = $this->video->query();

        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where("title", "LIKE", "%$request->search%");
                $query->orWhere("description", "LIKE", "%$request->search%");
            });
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('video_id')) {
            $query->where('id', $request->video_id);
        }

        $query->where('status', 1);

        $countVideo = $query->count();
        $videos = $query->paginate($request->per_page);

        $videos->getCollection()->transform(function ($video) {
            $thumbnail = url(Storage::url($video->thumbnail));

            $video->thumbnail = $thumbnail;

            return $video;
        });

        if ($request->has('video_id')) {
            return $this->detail($videos->items());
        }

        return MessageFixer::render(
            code: $countVideo > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
            message: $countVideo > 0 ? null : "Video no available.",
            data: $countVideo > 0 ? $videos->items() : null,
            paginate: ($videos instanceof LengthAwarePaginator) && $countVideo > 0  ? [
                "current_page" => $videos->currentPage(),
                "last_page" => $videos->lastPage(),
                "total" => $videos->total(),
                "from" => $videos->firstItem(),
                "to" => $videos->lastItem(),
            ] : null
        );
    }

    protected function detail($video)
    {
        return MessageFixer::render(
            code: count($video) > 0 ? MessageFixer::DATA_OK : MessageFixer::DATA_NULL,
            message: count($video) > 0 ? null : "Video no available.",
            data: count($video) > 0 ? $video[0] : null
        );
    }
}
