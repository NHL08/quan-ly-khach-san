<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserLevel;
use App\Models\Room;
use App\Models\RoomService;
use App\Models\RoomType;
use App\Models\Setting;
use App\Models\Student;
use App\Models\DataRoomService;
use App\Models\PaySetting;

use DB;
use Str;
use DateTime;
use Carbon\Carbon;

class BackController extends Controller
{
    public function __construct()
    {
        @session_start();

        $address = Setting::where('name','address')->first();
        view()->share('address', $address);

        $phone = Setting::where('name','phone')->first();
        view()->share('phone', $phone);

        $email = Setting::where('name','email')->first();
        view()->share('email', $email);

        $namehotel = Setting::where('name','namehotel')->first();
        view()->share('namehotel', $namehotel);

        $number_bank = PaySetting::where('name','number_bank')->value('content');
        view()->share('number_bank', $number_bank);

        $number_card = PaySetting::where('name','number_card')->value('content');
        view()->share('number_card', $number_card);

        $name_card = PaySetting::where('name','name_card')->value('content');
        view()->share('name_card', $name_card);

        $provinceCode = Setting::where('name', 'province')->value('content');
        $provinceName = getProvinceNameByCode($provinceCode);
        view()->share('provinceName', $provinceName);

        $districtCode = Setting::where('name', 'district')->value('content');
        $districtName = getDistrictNameByCode($provinceCode, $districtCode);
        view()->share('districtName', $districtName);

        $wardCode = Setting::where('name', 'ward')->value('content');
        $wardName = getWardNameByCode($provinceCode, $districtCode, $wardCode);
        view()->share('wardName', $wardName);
    }

    public function home()
    {
        $DataRoomService = DB::table('data_room_service')->select('name', 'usage_count')->get();
        $serviceDetails = [];
        $totalUsageCount = 0;

        foreach ($DataRoomService as $service) {
            $serviceDetails[] = [
                'label' => $service->name,
                'series' => $service->usage_count,
            ];

            $totalUsageCount += $service->usage_count;
        }

        return view('back.home.home', compact('serviceDetails', 'totalUsageCount'));
    }

    public function profile()
    {
        return view('back.home.profile');
    }

    public function profile_post(Request $request)
    {
        $User = User::find(auth()->user()->id);
        $User->fullname = $request->fullname;
        $User->address = $request->address;
        $User->phone = $request->phone;

        if ($request->hasFile('imageAvatar')) {
            $image = $request->file('imageAvatar');
            $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $image->getClientOriginalName());
            $destinationPath = public_path('avatar_image');
            $image->move($destinationPath, $filename);
            $User->avatar = $filename;
        }

        if (isset($request->password) && $request->password != '') {
            if (isset($request->confirmpassword) && $request->confirmpassword != '') {
                if ($request->password == $request->confirmpassword) {
                    $uppercase = preg_match('@[A-Z]@', $request->password);
                    $lowercase = preg_match('@[a-z]@', $request->password);
                    $number    = preg_match('@[0-9]@', $request->password);
                    $specialChars = preg_match('@[^\w]@', $request->password);

                    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($request->password) < 8) {
                        return redirect('admin/profile')->with(['flash_level'  => 'danger', 'flash_message' => 'Mật khẩu phải có độ dài ít nhất 8 ký tự và phải bao gồm ít nhất một chữ in hoa, một số và một ký tự đặc biệt.']);
                    }
                    $User->password = bcrypt($request->password);
                } else {
                    return redirect('admin/profile')->with(['flash_level' => 'danger', 'flash_message' => 'Xác nhận mật khẩu không chính xác']);
                }
            } else {
                return redirect('admin/profile')->with(['flash_level' => 'danger', 'flash_message' => 'Xác nhận mật khẩu không được để trống']);
            }
        }

        $User->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $User->save();

        return redirect('admin/profile')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa thông tin cá nhân thành công."]);
    }

    public function userList() {
        $User = DB::table('users as a')
            ->join('users_level as b', 'a.role', '=', 'b.id')
            ->selectRaw('a.id, a.fullname, a.address, a.phone, a.email, b.name')
            ->get();

        return view('back.manager.listuser', compact('User'));
    }

    public function userEdit(Request $request, $id) {
        $User = User::find($id);

        $UserLevel = UserLevel::where('status', 1)->get();

        return view('back.manager.edituser', compact('User', 'UserLevel'));
    }

    public function userEdit_post(Request $request, $id) {
        $User = User::find($id);
        $User->role = $request->level;
        $User->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Flag = $User->save();

        if ($Flag == true) {
            return redirect('admin/staff/list')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa tài khoản thành công."]);
        } else {
            return redirect('admin/staff/list')->with(['flash_level' => 'danger', 'flash_message' => "Chỉnh sửa tài khoản thất bại."]);
        }
    }

    public function roomList() {
        $rooms = DB::table('room as a')
            ->leftJoin('room_type as b', 'a.type', '=', 'b.id')
            ->leftJoin('users as u', 'a.user_id', '=', 'u.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'u.fullname', 'a.user_id', 'a.adults', 'a.children', 'a.deposited', 'a.note')
            ->get();

        foreach ($rooms as $room) {
            // Giải mã JSON để lấy danh sách dịch vụ và số lượng
            $serviceQuantities = json_decode($room->service, true);

            // Lấy thông tin dịch vụ cùng với số lượng
            $services = DB::table('room_service')
                ->whereIn('id', array_keys($serviceQuantities))
                ->select('id', 'name', 'price')
                ->get()
                ->keyBy('id'); // Tạo một mảng với key là id dịch vụ

            $serviceDetails = [];
            $totalServicePrice = 0;

            foreach ($serviceQuantities as $serviceId => $quantity) {
                if (isset($services[$serviceId])) {
                    $service = $services[$serviceId];
                    $serviceDetails[] = $service->name . ' (x' . $quantity . ')';
                    $totalServicePrice += $service->price * $quantity;
                }
            }

            if (empty($serviceDetails)) {
                $serviceDetails[] = 'Phòng không sử dụng dịch vụ nào';
            }

            $room->service = implode(', ', $serviceDetails);

            // Chuyển đổi ngày sang đối tượng DateTime và thiết lập năm hiện tại
            $currentYear = date('Y');
            $startDate = DateTime::createFromFormat('d/m/Y', $room->startday);
            $endDate = DateTime::createFromFormat('d/m/Y', $room->endday);

            if ($startDate && $endDate) {
                $startDate->setDate($startDate->format('Y'), $startDate->format('m'), $startDate->format('d'));
                $endDate->setDate($startDate->format('Y'), $endDate->format('m'), $endDate->format('d'));

                // Tính toán số ngày (bao gồm cả ngày bắt đầu và ngày kết thúc)
                $interval = $startDate->diff($endDate);
                $roomDays = $interval->days;

                if ($roomDays == 0) {
                    $roomDays = 1;
                }

                $room->rented_days = $roomDays;

                if ($room->status == 1) {
                    // Tính tổng tiền cho phòng đã thuê
                    $room->price = $totalServicePrice + ($room->price * $roomDays);
                }
            }

            if (!empty($room->endday)) {
                // Chuyển đổi định dạng ngày từ 'd/m' thành 'Y-m-d' nếu không có năm
                $endday = Carbon::createFromFormat('d/m/Y', $room->endday);

                // Thay đổi thời gian của ngày hết hạn thành 2 giờ chiều
                $enddayAt2PM = $endday->copy()->setTimezone('Asia/Ho_Chi_Minh')->setTime(14, 0);

                // Lấy thời gian hiện tại theo múi giờ Việt Nam
                $now = Carbon::now('Asia/Ho_Chi_Minh');

                // Thêm các thông tin vào đối tượng phòng
                $room->endday_formatted = $endday->format('d/m/Y');
                $room->isPast2PM = $now->greaterThanOrEqualTo($enddayAt2PM);
            } else {
                $room->endday_formatted = null;
                $room->isPast2PM = false;
            }
        }

        return view('back.manager.room.list', compact('rooms'));
    }

    public function roomListFind(Request $request) {
        $dateInput = Carbon::createFromFormat('d/m/Y', $request->input('datestart'))->format('Y-m-d');

        // Truy vấn dữ liệu phòng kèm loại phòng
        $rooms = DB::table('room as a')
            ->leftJoin('room_type as b', 'a.type', '=', 'b.id')
            ->leftJoin('users as u', 'a.user_id', '=', 'u.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'u.fullname', 'a.user_id', 'a.adults', 'a.children', 'a.deposited', 'a.note')
            ->whereRaw("CONVERT(DATE, a.startday, 103) <= ?", [$dateInput])
            ->whereRaw("CONVERT(DATE, a.endday, 103) >= ?", [$dateInput])
            ->get();

        foreach ($rooms as $room) {
            // Giải mã JSON để lấy danh sách dịch vụ và số lượng
            $serviceQuantities = json_decode($room->service, true);

            // Lấy thông tin dịch vụ cùng với số lượng
            $services = DB::table('room_service')
                ->whereIn('id', array_keys($serviceQuantities))
                ->select('id', 'name', 'price')
                ->get()
                ->keyBy('id');

            $serviceDetails = [];
            $totalServicePrice = 0;

            foreach ($serviceQuantities as $serviceId => $quantity) {
                if (isset($services[$serviceId])) {
                    $service = $services[$serviceId];
                    $serviceDetails[] = $service->name . ' (x' . $quantity . ')';
                    $totalServicePrice += $service->price * $quantity;
                }
            }

            if (empty($serviceDetails)) {
                $serviceDetails[] = 'Phòng không sử dụng dịch vụ nào';
            }

            $room->service = implode(', ', $serviceDetails);

            // Chuyển đổi ngày sang đối tượng DateTime và thiết lập năm hiện tại
            $currentYear = date('Y');
            $startDate = DateTime::createFromFormat('d/m/Y', $room->startday);
            $endDate = DateTime::createFromFormat('d/m/Y', $room->endday);

            if ($startDate && $endDate) {
                $startDate->setDate($currentYear, $startDate->format('m'), $startDate->format('d'));
                $endDate->setDate($currentYear, $endDate->format('m'), $endDate->format('d'));

                // Tính toán số ngày (bao gồm cả ngày bắt đầu và ngày kết thúc)
                $interval = $startDate->diff($endDate);
                $roomDays = $interval->days;

                if ($roomDays == 0) {
                    $roomDays = 1;
                }

                $room->rented_days = $roomDays;

                if ($room->status == 1) {
                    // Tính tổng tiền cho phòng đã thuê
                    $room->price = $totalServicePrice + ($room->price * $roomDays);
                }
            }

            if (!empty($room->endday)) {
                // Chuyển đổi định dạng ngày từ 'd/m/Y' thành đối tượng Carbon
                $endday = Carbon::createFromFormat('d/m/Y', $room->endday);

                // Thay đổi thời gian của ngày hết hạn thành 2 giờ chiều
                $enddayAt2PM = $endday->copy()->setTimezone('Asia/Ho_Chi_Minh')->setTime(14, 0);

                // Lấy thời gian hiện tại theo múi giờ Việt Nam
                $now = Carbon::now('Asia/Ho_Chi_Minh');

                // Thêm các thông tin vào đối tượng phòng
                $room->endday_formatted = $endday->format('d/m/Y');
                $room->isPast2PM = $now->greaterThanOrEqualTo($enddayAt2PM);
            } else {
                $room->endday_formatted = null;
                $room->isPast2PM = false;
            }
        }

        return view('back.manager.room.find', compact('rooms'));
    }

    public function roomService(Request $request, $roomId) {
        // Lấy thông tin phòng
        $Room = Room::find($roomId);
        // Lấy tất cả các dịch vụ
        $allServices = RoomService::all();
        // Giải mã JSON để lấy số lượng dịch vụ
        $selectedServiceQuantities = json_decode($Room->service, true);

        // Lấy thông tin dịch vụ và số lượng
        $selectedServices = RoomService::whereIn('id', array_keys($selectedServiceQuantities))
            ->get()
            ->keyBy('id'); // Tạo mảng với key là id dịch vụ

        // Truyền dữ liệu vào view
        return view('back.manager.room.service', [
            'Room' => $Room,
            'allServices' => $allServices,
            'selectedServices' => $selectedServices,
            'selectedServiceQuantities' => $selectedServiceQuantities
        ]);
    }

    public function roomService_post(Request $request, $roomId) {
        $room = Room::find($roomId);
        $serviceQuantities = $request->input('services', []);
        $filteredQuantities = array_filter($serviceQuantities, function($quantity) { return $quantity > 0; });
        $serviceQuantitiesJson = json_encode($filteredQuantities);

        foreach ($filteredQuantities as $serviceId => $newQuantity) {
            $dataRoomService = DB::table('data_room_service')->where('id', $serviceId)->first();

            if ($dataRoomService) {
                $currentUsageCount = $dataRoomService->usage_count;
                $updateUsageCount = $currentUsageCount - ($existingServices[$serviceId] ?? 0) + $newQuantity;

                DB::table('data_room_service')
                    ->where('id', $serviceId)
                    ->update(['usage_count' => $updateUsageCount]);

                $existingServices[$serviceId] = $newQuantity;
            }
        }

        $room->service = $serviceQuantitiesJson;
        $room->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $room->save();

        return redirect('admin/room/list')->with(['flash_level' => 'success', 'flash_message' => "Dịch vụ phòng đã được cập nhật thành công!"]);
    }

    public function roomCheckOut($roomId) {
        $Admin = DB::table('users as a')
            ->join('users_level as b', 'a.role', '=', 'b.id')
            ->selectRaw('a.id, a.fullname, a.address, a.phone, a.email, b.name as levelname')
            ->where('a.email', auth()->user()->email)
            ->first();

        $today = Carbon::now()->format('F, d, Y');

        $room = DB::table('room as a')
            ->join('room_type as b', 'a.type', '=', 'b.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price as room_price', 'a.status', 'a.user_id as user', 'a.startday', 'a.endday')
            ->where('a.id', $roomId)
            ->first();

        if ($room) {
            // Giải mã JSON để lấy danh sách dịch vụ và số lượng
            $serviceQuantities = json_decode($room->service, true);

            // Lấy thông tin dịch vụ cùng với số lượng
            $services = DB::table('room_service')
                ->whereIn('id', array_keys($serviceQuantities))
                ->select('id', 'name', 'price')
                ->get()
                ->keyBy('id'); // Tạo một mảng với key là id dịch vụ

            $serviceDetails = [];
            $totalServicePrice = 0;

            foreach ($serviceQuantities as $serviceId => $quantity) {
                if (isset($services[$serviceId])) {
                    $service = $services[$serviceId];
                    $serviceDetails[] = [
                        'name' => $service->name,
                        'price' => $service->price,
                        'quantity' => $quantity,
                        'total' => $service->price * $quantity,
                    ];
                    $totalServicePrice += $service->price * $quantity;
                }
            }

            $room->serviceDetails = $serviceDetails;

            // Chuyển đổi ngày sang đối tượng DateTime và thiết lập năm hiện tại
            $currentYear = date('Y');
            $startDate = DateTime::createFromFormat('d/m/Y', $room->startday);
            $endDate = DateTime::createFromFormat('d/m/Y', $room->endday);

            if ($startDate && $endDate) {
                $startDate->setDate($startDate->format('Y'), $startDate->format('m'), $startDate->format('d'));
                $endDate->setDate($startDate->format('Y'), $endDate->format('m'), $endDate->format('d'));

                // Tính toán số ngày (bao gồm cả ngày bắt đầu và ngày kết thúc)
                $interval = $startDate->diff($endDate);
                $roomDays = $interval->days;

                if($roomDays == 0) {
                    $roomDays = 1;
                }

                $room->rented_days = $roomDays;
            }

            $room->totalPrice = ($room->room_price * $roomDays) + $totalServicePrice; // Tổng giá phòng cộng với tổng giá dịch vụ

            // Lấy thông tin khách hàng nếu tồn tại thuộc tính 'user'
            $client = User::find($room->user);
        } else {
            // Xử lý khi không tìm thấy phòng
            $room = null;
            $client = null;
        }

        $maHoaDon = rand(1000, 9999);

        return view('back.manager.room.checkout', compact('roomId', 'Admin', 'today', 'room', 'client', 'maHoaDon'));
    }

    public function roomCheckOut_post(Request $request, $roomId) {
        $room = Room::find($roomId);

        if ($room) {
            $room->status = 0;
            $room->user_id = 0;
            $room->service = "{}";
            $room->startday = "";
            $room->endday = "";
            $room->adults = 0;
            $room->children = 0;
            $room->deposited = 0;
            $room->note = "";
            $room->save();

            return redirect('admin/room/list')->with(['flash_level' => 'success', 'flash_message' => "Thanh toán thành công!"]);
        } else {
            return redirect('admin/room/list')->with(['flash_level' => 'danger', 'flash_message' => "Phòng không tồn tại!"]);
        }
    }

    public function roomCheckIn($roomId) {
        $User = User::all();

        return view('back.manager.room.checkin', compact('roomId', 'User'));
    }

    public function roomCheckIn_post(Request $request, $roomId) {
        $room = Room::find($roomId);

        $dateRange = explode(' - ', $request->datetimes);

        if ($request->adults == 0) {
            return redirect('admin/room/checkin/'.$roomId)->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng chọn số người lớn!"]);
        }

        if ($room) {
            $room->startday = $dateRange[0];
            $room->endday = $dateRange[1];
            // $room->day = $nights;
            $room->status = 1;
            $room->user_id = $request->user;
            $room->adults = $request->adults;
            $room->children = $request->children;
            $room->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $room->save();

            return redirect('admin/room/list')->with(['flash_level' => 'success', 'flash_message' => "Thuê phòng thành công!"]);
        } else {
            return redirect('admin/room/list')->with(['flash_level' => 'danger', 'flash_message' => "Phòng không tồn tại!"]);
        }
    }

    public function roomAdd() {
        $RoomType = DB::table('room_type')->get();
        return view('back.manager.room.add', compact('RoomType'));
    }

    public function roomAdd_post(Request $request) {
        if (empty($request->idroom) || empty($request->type)) {
            return redirect('admin/room/add')->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng nhập những trường đánh dấu *"]);
        }

        $existingRoom = Room::find($request->idroom);
        if ($existingRoom) {
            return redirect('admin/room/add')->with(['flash_level' => 'danger', 'flash_message' => "ID phòng đã tồn tại. Vui lòng chọn ID khác."]);
        }

        $RoomType = DB::table('room_type')
            ->where('id', $request->type)
            ->first();

        $Room = new Room();
        $Room->id = $request->idroom;
        $Room->type = $request->type;
        $Room->startday = "";
        $Room->endday = "";
        $Room->service = "{}";
        $Room->status = 0;
        $Room->user_id = 0;
        $Room->adults = 0;
        $Room->children = 0;
        $Room->deposited = 0;
        $Room->note = '';
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                // Tạo tên file duy nhất
                $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $image->getClientOriginalName());
                // Đường dẫn lưu file trong thư mục public
                $destinationPath = public_path('room_images');
                // Di chuyển file tới thư mục public
                $image->move($destinationPath, $filename);
                // Lưu tên file vào mảng
                // $uploadedImages[] = 'public/room_images/'.$filename;
                $uploadedImages[] = $filename;
            }
        }

        $Room->image = json_encode($uploadedImages);
        $Room->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Room->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Room->save();

        return redirect('admin/room/list')->with(['flash_level' => 'success', 'flash_message' => "Thêm phòng thành công!"]);
    }

    public function roomDelete($roomId) {
        $Room = Room::find($roomId);
        $Room->delete();

        return redirect('admin/room/list')->with(['flash_level' => 'success', 'flash_message' => "Xóa phòng thành công!"]);
    }

    public function roomEdit($roomId) {
        $rooms = DB::table('room as a')
            ->join('room_type as b', 'a.type', '=', 'b.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image', 'b.id as type_id')
            ->where('a.id', $roomId)
            ->first();

        $RoomType = DB::table('room_type')->get();

        $existingImagesJson = $rooms->image; // Lấy chuỗi JSON từ cơ sở dữ liệu
        $existingImages = json_decode($existingImagesJson, true); // Giải mã chuỗi JSON thành mảng

        // Kiểm tra và xử lý nếu giải mã không thành công
        if (!is_array($existingImages)) {
            $existingImages = []; // Hoặc xử lý lỗi tùy ý
        }

        return view('back.manager.room.edit', compact('roomId', 'rooms', 'existingImages', 'RoomType'));
    }

    public function roomEdit_post(Request $request, $roomId) {
        $Room = Room::find($roomId);

        $uploadedImages = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                // Tạo tên file duy nhất
                $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $image->getClientOriginalName());
                // Đường dẫn lưu file trong thư mục public
                $destinationPath = public_path('room_images');
                // Di chuyển file tới thư mục public
                $image->move($destinationPath, $filename);
                // Lưu tên file vào mảng
                // $uploadedImages[] = 'public/room_images/'.$filename;
                $uploadedImages[] = $filename;
            }
        }

        $Room->type = $request->type;
        $Room->image = json_encode($uploadedImages);
        $Room->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Room->save();

        return redirect('admin/room/list')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa phòng thành công!"]);
    }

    public function serviceList() {
        // $services = RoomService::all();
        $services = DB::table('room_service as a')
        ->join('data_room_service as b', 'a.id', '=', 'b.id')
        ->select('a.id', 'a.name', 'a.price', 'b.usage_count')
        ->get();

        return view('back.manager.service.list', compact('services'));
    }

    public function serviceEdit($serviceId) {
        $Service = RoomService::find($serviceId);

        return view('back.manager.service.edit', compact('serviceId', 'Service'));
    }

    public function serviceEdit_post(Request $request, $serviceId) {
        $Service = RoomService::find($serviceId);
        $Service->price = str_replace('.', '', $request->price);
        $Service->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Service->save();

        return redirect('admin/service/list')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa dịch vụ thành công!"]);
    }

    public function serviceDelete($serviceId) {
        $Service = RoomService::find($serviceId);
        $Data_Service = DataRoomService::find($serviceId);
        $Data_Service->delete();
        $Service->delete();

        return redirect('admin/service/list')->with(['flash_level' => 'success', 'flash_message' => "Xóa dịch vụ thành công!"]);
    }

    public function serviceAdd() {
        return view('back.manager.service.add');
    }

    public function serviceAdd_post(Request $request) {
        if (empty($request->name) || empty($request->price)) {
            return redirect('admin/service/add')->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng nhập những trường đánh dấu *"]);
        }
        $Service = new RoomService();
        $Service->name = $request->name;
        $Service->price = str_replace('.', '', $request->price);
        $Service->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Service->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Service->save();

        $Data_Service = new DataRoomService();
        $Data_Service->name = $request->name;
        $Data_Service->usage_count = 0;
        $Data_Service->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Data_Service->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Data_Service->save();

        return redirect('admin/service/list')->with(['flash_level' => 'success', 'flash_message' => "Thêm dịch vụ thành công!"]);
    }

    public function typeRoomList() {
        $RoomType = DB::table('room_type')->get();

        $roomCounts = DB::table('room')
            ->select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type');

        return view('back.manager.typeroom.list', compact('RoomType', 'roomCounts'));
    }

    public function typeRoomDelete($typeId) {
        $RoomType = DB::table('room_type')->where('id', $typeId)->delete();
        return redirect('admin/typeroom/list')->with(['flash_level' => 'success', 'flash_message' => "Xóa loại phòng thành công!"]);
    }

    public function typeRoomAdd() {
        return view('back.manager.typeroom.add');
    }

    public function typeRoomAdd_post(Request $request) {
        if (empty($request->name) || empty($request->price)) {
            return redirect('admin/typeroom/add')->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng nhập những trường đánh dấu *"]);
        }
        $RoomType = DB::table('room_type')->insert([
            'name' => $request->name,
            'price' => str_replace('.', '', $request->price),
            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')
        ]);

        return redirect('admin/typeroom/list')->with(['flash_level' => 'success', 'flash_message' => "Thêm loại phòng thành công!"]);
    }

    public function settingEdit() {
        $settings = Setting::all();
        $settingsArray = $settings->pluck('content', 'name')->toArray();
        $provinceCode = $settingsArray['province'] ?? null;
        $districtCode = $settingsArray['district'] ?? null;
        $wardCode = $settingsArray['ward'] ?? null;
        $provinces = getProvinces();
        $districts = [];
        $wards = [];

        if ($provinceCode) {
            $districts = getDistrictsByProvinceCode($provinceCode);
            if ($districtCode) {
                $wards = getWardsByDistrictCode($provinceCode, $districtCode);
            }
        }

        $setting = (object) [
            'address' => $settingsArray['address'] ?? '',
            'province' => $provinceCode,
            'district' => $districtCode,
            'ward' => $wardCode,
            'email' => $settingsArray['email'] ?? '',
            'phone' => $settingsArray['phone'] ?? '',
            'image' => json_decode($settingsArray['imagehotel'] ?? '[]', true),
            'namehotel' => $settingsArray['namehotel'] ?? '',
            'manager' => $settingsArray['manager'] ?? '',
            'time' => $settingsArray['time'] ?? '',
            'logowebsite' => $settingsArray['logowebsite'] ?? '',
            'logofooter' => $settingsArray['logofooter'] ?? '',
        ];

        return view('back.manager.settings.edit', compact('setting', 'provinces', 'districts', 'wards'));
    }

    public function settingEdit_post(Request $request) {
        $uploadedImages = [];

        $email = Setting::where('name', 'email')->first();
        $email->content = $request->email;
        $email->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $email->save();

        $phone = Setting::where('name', 'phone')->first();
        $phone->content = $request->phone;
        $phone->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $phone->save();

        $address = Setting::where('name', 'address')->first();
        $address->content = $request->address;
        $address->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $address->save();

        $namehotel = Setting::where('name', 'namehotel')->first();
        $namehotel->content = $request->namehotel;
        $namehotel->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $namehotel->save();

        $manager = Setting::where('name', 'manager')->first();
        $manager->content = $request->manager;
        $manager->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $manager->save();

        $time = Setting::where('name', 'time')->first();
        $time->content = $request->time;
        $time->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $time->save();

        $province = Setting::where('name', 'province')->first();
        $province->content = $request->province;
        $province->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $province->save();

        $district = Setting::where('name', 'district')->first();
        $district->content = $request->district;
        $district->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $district->save();

        $ward = Setting::where('name', 'ward')->first();
        $ward->content = $request->ward;
        $ward->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $ward->save();

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                // Tạo tên file duy nhất
                $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $image->getClientOriginalName());
                // Đường dẫn lưu file trong thư mục public
                $destinationPath = public_path('hotel_images');
                // Di chuyển file tới thư mục public
                $image->move($destinationPath, $filename);
                // Lưu tên file vào mảng
                // $uploadedImages[] = 'public/hotel_images/'.$filename;
                $uploadedImages[] = $filename;
            }
            $setting = Setting::where('name', 'imagehotel')->first();
            $setting->content = json_encode($uploadedImages);
            $setting->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $setting->save();
        }

        if ($request->hasFile('logowebsite')) {
            $logowebsite = $request->file('logowebsite');
            $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $logowebsite->getClientOriginalName());
            $destinationPath = public_path('hotel_images');
            $logowebsite->move($destinationPath, $filename);
            $setting = Setting::where('name', 'logowebsite')->first();
            $setting->content = $filename;
            $setting->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $setting->save();
        }

        if ($request->hasFile('logofooter')) {
            $logofooter = $request->file('logofooter');
            $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $logofooter->getClientOriginalName());
            $destinationPath = public_path('hotel_images');
            $logofooter->move($destinationPath, $filename);
            $setting = Setting::where('name', 'logofooter')->first();
            $setting->content = $filename;
            $setting->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $setting->save();
        }

        return redirect('admin/settings')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa cài đặt thành công!"]);
    }

    public function student() {
        $students = Student::all();
        $countStudent = Student::where('status', 1)->count();

        return view('back.manager.settings.student', compact('students', 'countStudent'));
    }

    public function student_post(Request $request) {
        for ($i = 1; $i <= 4; $i++) {
            $nameField = 'namestudent' . $i;
            $masvField = 'masvstudent' . $i;
            $roleField = 'role' . $i;
            $imageField = 'imagestudent' . $i;

            if (!empty($request->$nameField) && !empty($request->$masvField)) {
                $Student = Student::find($i);
                $Student->fullname = $request->$nameField;
                $Student->masv = $request->$masvField;
                $Student->role = $request->$roleField;
                $Student->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $Student->save();
            }

            if ($request->hasFile($imageField)) {
                $image = $request->file($imageField);
                $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $image->getClientOriginalName());
                $destinationPath = public_path('student_image');
                $image->move($destinationPath, $filename);

                $Student = Student::find($i);
                $Student->avatar = $filename;
                $Student->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
                $Student->save();
            }
        }

        return redirect('admin/settings/student')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa sinh viên thành công!"]);
    }

    public function studentAdd() {
        return view('back.manager.settings.studentadd');
    }

    public function studentAdd_post(Request $request) {
        if (empty($request->namestudent) || empty($request->masvstudent) || empty($request->role)) {
            return redirect('admin/settings/student/add')->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng nhập những trường đánh dấu *"]);
        }

        $Student = new Student();
        $Student->fullname = $request->namestudent;
        $Student->masv = $request->masvstudent;
        $Student->role = $request->role;

        if ($request->hasFile('imagestudent')) {
            $imagestudent = $request->file('imagestudent');
            $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $imagestudent->getClientOriginalName());
            $destinationPath = public_path('student_image');
            $imagestudent->move($destinationPath, $filename);
            $Student->avatar = $filename;
        }

        $Student->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Student->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Student->save();

        return redirect('admin/settings/student')->with(['flash_level' => 'success', 'flash_message' => "Thêm sinh viên thành công!"]);
    }

    public function studentOn($id) {
        $Student = Student::find($id);
        $Student->status = 1;
        $Student->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Student->save();

        return redirect('admin/settings/student')->with(['flash_level' => 'success', 'flash_message' => "Kích hoạt sinh viên thành công!"]);
    }

    public function studentOff($id) {
        $Student = Student::find($id);
        $Student->status = 0;
        $Student->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $Student->save();

        return redirect('admin/settings/student')->with(['flash_level' => 'success', 'flash_message' => "Vô hiệu hóa sinh viên thành công!"]);
    }

    public function pay() {
        $pay = PaySetting::get();
        $payArray = $pay->pluck('content', 'name')->toArray();

        $pay = (object) [
            'name_card' => $payArray['name_card'] ?? '',
            'number_card' => $payArray['number_card'] ?? '',
            'address_card' => $payArray['address_card'] ?? '',
            'branch_card' => $payArray['branch_card'] ?? '',
            'number_bank' => $payArray['number_bank'] ?? '',
        ];

        return view('back.manager.settings.pay', compact('pay'));
    }

    public function pay_post(Request $request) {
        $nameCard = PaySetting::where('name', 'name_card')->first();

        $name_card = $request->name_card;
        $name_card = removeAccents($name_card);
        $name_card = mb_strtoupper($name_card, 'UTF-8');

        $nameCard->content = $name_card;
        $nameCard->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $nameCard->save();

        $numberCard = PaySetting::where('name', 'number_card')->first();
        $numberCard->content = $request->number_card;
        $numberCard->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $numberCard->save();

        $nameBank = PaySetting::where('name', 'name_bank')->first();
        $nameBank->content = $request->name_bank;
        $nameBank->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $nameBank->save();

        $branchCard = PaySetting::where('name', 'branch_card')->first();
        $branchCard->content = $request->branch_card;
        $branchCard->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $branchCard->save();

        $numberBank = PaySetting::where('name', 'number_bank')->first();
        $numberBank->content = $request->address_card;
        $numberBank->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $numberBank->save();

        return redirect('admin/settings/pay')->with(['flash_level' => 'success', 'flash_message' => "Chỉnh sửa cài đặt thanh toán thành công!"]);
    }
}
