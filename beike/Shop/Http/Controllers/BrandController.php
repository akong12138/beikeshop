<?php

namespace Beike\Shop\Http\Controllers;

use Beike\Repositories\BrandRepo;
use Beike\Shop\Http\Resources\ProductSimple;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = BrandRepo::listGroupByFirst();
        $data   = [
            'brands' => $brands,
        ];

        return view('brand/list', $data);
    }

    public function show(int $id)
    {
        $brand    = BrandRepo::find($id);
        $products = $brand->products()
            ->with([
                'masterSku',
                'description',
                'inCurrentWishlist',
            ])
            ->paginate(perPage());

        $data = [
            'brand'           => $brand,
            'products'        => $products,
            'products_format' => ProductSimple::collection($products)->jsonSerialize(),
        ];

        return view('brand/info', $data);
    }

    public function autocomplete(Request $request)
    {
        $brands = BrandRepo::autocomplete($request->get('name') ?? '');

        return json_success(trans('common.get_success'), $brands);
    }
}
