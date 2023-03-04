<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Models\Village;

class AddresssController extends Controller
{
    /**
     * Get provinces list
     */
    public function provinces(Request $request): JsonResponse
    {
        $provinces = Province::select(['code', 'name']);

        if ($request->has('name') && is_null($request->input('name')) === false) {
            $provinces->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return Response::json($provinces->get());
    }

    /**
     * Get city list based on province
     */
    public function cities(Request $request, string $provinceCode): JsonResponse
    {
        $city = City::select('code', 'name')->where('province_code', $provinceCode);

        if ($request->has('name') && is_null($request->input('name')) === false) {
            $city->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return Response::json($city->get());
    }

    /**
     * Get districts list
     */
    public function districts(Request $request, string $cityCode): JsonResponse
    {
        $districts = District::select('code', 'name')->where('city_code', $cityCode);

        if ($request->has('name') && is_null($request->input('name')) === false) {
            $districts->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return Response::json($districts->get());
    }

    /**
     * Get villages list
     */
    public function villages(Request $request, string $districtCode): JsonResponse
    {
        $villages = Village::select('code', 'name')->where('district_code', $districtCode);

        if ($request->has('name') && is_null($request->input('name')) === false) {
            $villages->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return Response::json($villages->get());
    }
}
