<?php

if (! function_exists('remove_protocol')) {
    function remove_protocol($url) {
        return str_replace(['http://', 'https://'], '', $url);
    }
}

if (!function_exists('getProvinces')) {
    function getProvinces()
    {
        $path = public_path('vn.json');
        if (!file_exists($path)) {
            return [];
        }

        $jsonContent = file_get_contents($path);
        $data = json_decode($jsonContent, true);

        $provinces = [];
        foreach ($data as $item) {
            $provinces[] = [
                'Code' => $item['Code'],
                'FullName' => $item['FullName'],
            ];
        }

        return $provinces;
    }
}

if (!function_exists('getDistrictsByProvinceCode')) {
    function getDistrictsByProvinceCode($provinceCode)
    {
        $path = public_path('vn.json');
        if (!file_exists($path)) {
            return [];
        }

        $jsonContent = file_get_contents($path);
        $data = json_decode($jsonContent, true);

        $districts = [];
        foreach ($data as $province) {
            if (isset($province['Code']) && $province['Code'] === $provinceCode) {
                if (isset($province['District']) && is_array($province['District'])) {
                    foreach ($province['District'] as $district) {
                        $districts[] = [
                            'Code' => $district['Code'],
                            'FullName' => $district['FullName'],
                            'ProvinceCode' => $district['ProvinceCode']
                        ];
                    }
                }
                break;
            }
        }

        return $districts;
    }
}

if (!function_exists('getWardsByDistrictCode')) {
    function getWardsByDistrictCode($provinceCode, $districtCode)
    {
        $path = public_path('vn.json');
        if (!file_exists($path)) {
            return [];
        }

        $jsonContent = file_get_contents($path);
        $data = json_decode($jsonContent, true);

        $wards = [];
        foreach ($data as $province) {
            if (isset($province['Code']) && $province['Code'] === $provinceCode) {
                if (isset($province['District']) && is_array($province['District'])) {
                    foreach ($province['District'] as $district) {
                        if (isset($district['Code']) && $district['Code'] === $districtCode) {
                            if (isset($district['Ward']) && is_array($district['Ward'])) {
                                foreach ($district['Ward'] as $ward) {
                                    $wards[] = [
                                        'Code' => $ward['Code'],
                                        'FullName' => $ward['FullName'],
                                        'DistrictCode' => $ward['DistrictCode']
                                    ];
                                }
                            }
                            break;
                        }
                    }
                }
                break;
            }
        }

        return $wards;
    }
}

if (!function_exists('getProvinceNameByCode')) {
    function getProvinceNameByCode($code) {
        $provinces = getProvinces();
        $province = collect($provinces)->firstWhere('Code', $code);
        return $province['FullName'] ?? null;
    }
}

if (!function_exists('getDistrictNameByCode')) {
    function getDistrictNameByCode($provinceCode, $districtCode) {
        $districts = getDistrictsByProvinceCode($provinceCode);
        $district = collect($districts)->firstWhere('Code', $districtCode);
        return $district['FullName'] ?? null;
    }
}

if (!function_exists('getWardNameByCode')) {
    function getWardNameByCode($provinceCode, $districtCode, $wardCode) {
        $wards = getWardsByDistrictCode($provinceCode, $districtCode);
        $ward = collect($wards)->firstWhere('Code', $wardCode);
        return $ward['FullName'] ?? null;
    }
}

if (!function_exists('getBank')) {
    function getBank()
    {
        $path = public_path('bank.json');
        if (!file_exists($path)) {
            return [];
        }

        $jsonContent = file_get_contents($path);
        $data = json_decode($jsonContent, true);

        $provinces = [];
        foreach ($data as $item) {
            $provinces[] = [
                'name_bank' => $item['name'],
                'code_bank' => $item['code'],
                'number_bank' => $item['bin'],
                'shortName' => $item['shortName'],
            ];
        }

        return $provinces;
    }
}

if (!function_exists('removeAccents')) {
    function removeAccents($str) {
        $accented = [
            'à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ',
            'è', 'é', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ',
            'ì', 'í', 'ỉ', 'ĩ', 'ị',
            'ò', 'ó', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ',
            'ù', 'ú', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự',
            'ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ',
            'đ',
            'À', 'Á', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ',
            'È', 'É', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ',
            'Ì', 'Í', 'Ỉ', 'Ĩ', 'Ị',
            'Ò', 'Ó', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ',
            'Ù', 'Ú', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự',
            'Ỳ', 'Ý', 'Ỷ', 'Ỹ', 'Ỵ',
            'Đ'
        ];
        $unaccented = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd',
            'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
            'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
            'I', 'I', 'I', 'I', 'I',
            'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y', 'Y', 'Y', 'Y',
            'D'
        ];

        return str_replace($accented, $unaccented, $str);
    }
}
