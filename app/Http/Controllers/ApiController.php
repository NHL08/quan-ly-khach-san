<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function api_vn() {
        $path = public_path('vn.json');
        $jsonContent = file_get_contents($path);
        $data = json_decode($jsonContent, true);

        return response()->json($data);
    }

    public function getAllProvinces() {
        $provinces = getProvinces();

        return response()->json($provinces);
    }

    public function getDistrictsByProvinceCode($provinceCode)
    {
        $districts = getDistrictsByProvinceCode($provinceCode);
        return response()->json($districts);
    }

    public function getWardsByDistrictCode($provinceCode, $districtCode)
    {
        $wards = getWardsByDistrictCode($provinceCode, $districtCode);
        return response()->json($wards);
    }

    public function getBank() {
        $banks = getBank();
        return response()->json($banks);
    }
}
