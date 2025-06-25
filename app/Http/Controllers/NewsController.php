<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsResource;
use App\Services\NewsService;

class NewsController extends Controller
{
    public function __construct(protected NewsService $service)
    {

    }

    /**
     * Listeleme işlemi
     */
    public function index()
    {
        return NewsResource::collection($this->service->listForPublic());
    }

    /**
     * Yeni haber ekleme işlemi
     */
    public function store(StoreNewsRequest $request)
    {
        try {
            $news = $this->service->store($request);
            return response()->json(['message' => 'Haber başarıyla eklendi!', 'data' => NewsResource::make($news)], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Haber detaylarını gösterme işlemi
     */
    public function show(string $id)
    {
        return new NewsResource($this->service->showForPublic($id));
    }

    /**
     * Haberi güncelleme işlemi
     */
    public function update(UpdateNewsRequest $request, string $id)
    {
        return new NewsResource($this->service->update($request, $id));
    }

    /**
     * Haberi silme işlemi
     */
    public function destroy(string $id)
    {
        $this->service->destroy($id);
        return response()->json([], 204);
    }
}
