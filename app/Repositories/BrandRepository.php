<?php


namespace App\Repositories;


use App\Models\Brand;
use App\Traits\UploadAble;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Str;

class BrandRepository implements \App\Contracts\BrandContract
{
    use UploadAble;
    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return Brand::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $params, array $relations = null)
    {
        $brand = Brand::where($params);
        if (is_array($relations))
        {
            $brand = $brand->with($relations);
        }
         return $brand->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function findByFilter($per_page = 10,array $relations = [])
    {
        return app(Pipeline::class)
            ->send(Brand::with($relations)->orderBy('created_at','desc')->newQuery())
            ->through([
                \App\QueryFilter\Search::class
            ])
            ->thenReturn()
            ->paginate($per_page)
            ->appends(request()->query());
    }

    /**
     * @inheritDoc
     */
    public function add(array $data)
    {
        if (isset($data['image']))
        {
            $data['image'] = $this->uploadOne($data['image'],'brand','public');
        }
        $data['slug'] = Str::slug($data['name']);
        $b =  brand::create($data);
        $b->categories()->attach($data['categories']);
        return $b;
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $brand = $this->findById($id);
        if (isset($data['image']))
        {
            if (isset($brand->image))
            {
                $this->deleteOne($brand->image,'public');
            }
            $data['image'] = $this->uploadOne($data['image'],'brand','public');
        }
        $data['slug'] = Str::slug($data['name']);
        $brand->update($data);
        $brand->categories()->sync($data['categories']);
        return $brand->refresh();
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        $brand = $this->findById($id);
        if (isset($brand->image))
        {
            $this->deleteOne($brand->image,'public');
        }
        return $brand->delete();
    }

    public function all(array $relations = [])
    {
        return Brand::with($relations)->orderBy('name','asc')->get();
    }
}
