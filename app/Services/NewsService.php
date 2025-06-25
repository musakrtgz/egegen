<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;

class NewsService
{

    public function __construct(protected News $model)
    {
    }

    /**
     * Sayfalama ile Listeleme işlemi
     * Aktif ve yayınlanmış haberleri getirir
     * Arama sorgusu varsa başlık veya içerikte arama yapar
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listForPublic(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->active() // aktif olanları getir
            ->published() // yayınlanmış olanları getir
            ->latest() // en son eklenenleri getir
            ->when(request('search'), function ($query) { // arama sorgusu varsa
                $query->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('content', 'like', '%' . request('search') . '%');
            })
            ->paginate(10) // sayfalama
            ->withQueryString(); // sorgu stringini koru
    }

    /**
     * Haber detaylarını gösterme işlemi
     * @param int $id
     * @return News
     */
    public function showForPublic($id)
    {
        return $this->model::active() // aktif olanları getir
        ->published() // yayınlanmış olanları getir
        ->findOrFail($id); // id ile bul, yoksa 404 döner
    }

    /**
     * Yeni haber ekleme işlemi
     * @param Request $request
     * return News
     */
    public function store(Request $request): News
    {
        // resim yoluyla birlikte haber ekle
        return $this->model->create([
            ...$request->validated(), // doğrulanmış datayı al
            'image' => (new ImageUploadService())->upload($request->file('image')) // resim varsa yükle
        ]);
    }

    /**
     * Haberi güncelleme işlemi
     * @param Request $request
     * @param int $id
     * @return News
     */
    public function update(Request $request, $id): News
    {
        $data = $request->validated(); // doğrulanmış datayı al

        // resim varsa güncelle
        if ($request->hasFile('image')) {
            $data['image'] = (new ImageUploadService())->upload($request->file('image'));
        }

        // haberi güncelle
        $news = $this->model->findOrFail($id); // id ile haberi bul, yoksa 404 döner
        $news->update($data);
        return $news;
    }

    /**
     * Haberi silme işlemi
     * @param int $id
     * @return void
     */
    public function destroy($id): void
    {
        $news = $this->model->findOrFail($id); // id ile haberi bul, yoksa 404 döner
        $news->delete(); // haberi sil
    }

}
