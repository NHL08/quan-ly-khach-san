<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Setting;
use App\Models\Review;
use App\Models\Student;
use App\Models\PaySetting;

use Auth;
use DB;
use DateTime;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function __construct() {
        @session_start();

        $address = Setting::where('name','address')->first();
        view()->share('address', $address);

        $phone = Setting::where('name','phone')->first();
        view()->share('phone', $phone);

        $email = Setting::where('name','email')->first();
        view()->share('email', $email);

        $time = Setting::where('name','time')->first();
        view()->share('time', $time);

        $namehotel = Setting::where('name','namehotel')->first();
        view()->share('namehotel', $namehotel);

        $manager = Setting::where('name','manager')->first();
        view()->share('manager', $manager);

        $logowebsite = Setting::where('name','logowebsite')->first();
        view()->share('logowebsite', $logowebsite);

        $logofooter = Setting::where('name','logofooter')->first();
        view()->share('logofooter', $logofooter);

        $provinceCode = Setting::where('name', 'province')->value('content');
        $provinceName = getProvinceNameByCode($provinceCode);
        view()->share('provinceName', $provinceName);

        $districtCode = Setting::where('name', 'district')->value('content');
        $districtName = getDistrictNameByCode($provinceCode, $districtCode);
        view()->share('districtName', $districtName);

        $wardCode = Setting::where('name', 'ward')->value('content');
        $wardName = getWardNameByCode($provinceCode, $districtCode, $wardCode);
        view()->share('wardName', $wardName);

        $number_bank = PaySetting::where('name','number_bank')->value('content');
        view()->share('number_bank', $number_bank);

        $number_card = PaySetting::where('name','number_card')->value('content');
        view()->share('number_card', $number_card);

        $name_card = PaySetting::where('name','name_card')->value('content');
        view()->share('name_card', $name_card);

        $name_bank = PaySetting::where('name','name_bank')->value('content');
        view()->share('name_bank', $name_bank);

        $branch_card = PaySetting::where('name','branch_card')->value('content');
        view()->share('branch_card', $branch_card);
    }

    public function home() {
        $roomtype = RoomType::all();

        $imagehotel = json_decode(Setting::where('name', 'imagehotel')->pluck('content')->first(), true);

        $roomTypes = DB::table('room_type')->pluck('id');

        $rooms = collect();

        foreach ($roomTypes as $typeId) {
            $room = DB::table('room as a')
                ->join('room_type as b', 'a.type', '=', 'b.id')
                ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image')
                ->where('a.type', $typeId)
                ->where('startday', '')
                ->where('endday', '')
                ->first();

            if ($room) {
                $rooms->push($room);
                if ($rooms->count() >= 5) {
                    break;
                }
            }
        }

        foreach ($rooms as $room) {
            $room->image = json_decode($room->image, true);
        }

        $students = Student::where('status', 1)->get();

        return view('front.home', compact('roomtype', 'imagehotel', 'rooms','students'));
    }

    public function hotel(Request $request) {
        $roomtype = RoomType::all();
        if($request->query() != null && !$request->query('page')){
            $checkin = $request->query('checkin');
            $checkout = $request->query('checkout');
            $typeroom = $request->query('typeroom');
            $rooms = DB::table('room as a')
                ->join('room_type as b', 'a.type', '=', 'b.id')
                ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image')
                ->where('type', $typeroom)
                ->where('startday', '')
                ->where('endday', '')
                ->paginate(3);

            foreach ($rooms as $room) {
                $room->image = json_decode($room->image, true);
            }

            return view('front.hotel', compact('roomtype','rooms','typeroom'));
        }
        else{
            $rooms = DB::table('room as a')
                ->join('room_type as b', 'a.type', '=', 'b.id')
                ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image')
                ->where('startday', '')
                ->where('endday', '')
                ->paginate(3);

            foreach ($rooms as $room) {
                $room->image = json_decode($room->image, true);
            }

            return view('front.hotel', compact('roomtype','rooms'));
        }
    }

    public function roomDetail($id) {
        $room = DB::table('room as a')
            ->join('room_type as b', 'a.type', '=', 'b.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image')
            ->where('a.id', $id)
            ->first();

        $room->image = json_decode($room->image, true);

        $reviews = DB::table('review as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->select('a.content', 'a.rating', 'a.created_at', 'b.fullname', 'b.avatar')
            ->where('a.room_id', $id)
            ->get();
        return view('front.hotel-details', compact('room', 'reviews'));
    }

    public function roomDetail_post(Request $request, $id) {
        if ($request->checkIn == null || $request->checkOut == null) {
            return redirect('hotel/room/'.$id)->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng chọn ngày nhận và trả phòng!"]);
        }

        if ($request->adults == 0) {
            return redirect('hotel/room/'.$id)->withInput()->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng chọn số người lớn!"]);
        }

        return redirect('hotel/room/'.$id.'/book?checkIn='.$request->checkIn.'&checkOut='.$request->checkOut.'&adults='.$request->adults.'&children='.$request->children);
    }

    public function roomBook(Request $request, $id) {
        $room = DB::table('room as a')
            ->join('room_type as b', 'a.type', '=', 'b.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image')
            ->where('a.id', $id)
            ->first();

        $room->image = json_decode($room->image, true);

        $currentYear = date('Y');
        $startDate = DateTime::createFromFormat('d/m/Y', $request->query('checkIn'));
        $endDate = DateTime::createFromFormat('d/m/Y', $request->query('checkOut'));

        if ($startDate && $endDate) {
            $startDate->setDate($startDate->format('Y'), $startDate->format('m'), $startDate->format('d'));
            $endDate->setDate($startDate->format('Y'), $endDate->format('m'), $endDate->format('d'));

            $interval = $startDate->diff($endDate);
            $roomDays = $interval->days;

            if ($roomDays == 0) {
                $roomDays = 1;
            }

            $room->rented_days = $roomDays;

            $room->total_price = $room->price * $roomDays;
        }

        return view('front.room-book', compact('id', 'room'));
    }

    public function roomBook_post(Request $request, $id) {
        $room = Room::find($id);
        $room->startday = $request->checkIn;
        $room->endday = $request->checkOut;
        $room->adults = $request->adults;
        $room->children = $request->children;
        $room->status = 1;
        $room->user_id = Auth::user()->id ?? 10000;
        $room->deposited = 1;
        $room->note = $request->note ?? "Không có ghi chú";
        $room->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $room->save();

        return redirect('room')->with(['flash_level' => 'success', 'flash_message' => "Đặt phòng thành công!"]);
    }

    public function account() {
        return view('front.account');
    }

    public function account_post(Request $request) {
        $user = Auth::user();
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if (isset($request->password) && $request->password != '') {
            if (isset($request->confirmpassword) && $request->confirmpassword != '') {
                if ($request->password == $request->confirmpassword) {
                    $uppercase = preg_match('@[A-Z]@', $request->password);
                    $lowercase = preg_match('@[a-z]@', $request->password);
                    $number    = preg_match('@[0-9]@', $request->password);
                    $specialChars = preg_match('@[^\w]@', $request->password);

                    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($request->password) < 8) {
                        return redirect('account')->with(['flash_level'  => 'danger', 'flash_message' => 'Mật khẩu phải có độ dài ít nhất 8 ký tự và phải bao gồm ít nhất một chữ in hoa, một số và một ký tự đặc biệt.']);
                    }
                    $user->password = bcrypt($request->password);
                } else {
                    return redirect('account')->with(['flash_level' => 'danger', 'flash_message' => 'Xác nhận mật khẩu không chính xác']);
                }
            } else {
                return redirect('account')->with(['flash_level' => 'danger', 'flash_message' => 'Xác nhận mật khẩu không được để trống']);
            }
        }
        if ($request->hasFile('imageAvatar')) {
            $image = $request->file('imageAvatar');
            $filename = time() . '_' . str_replace([' ', '-', '(', ')'], '_', $image->getClientOriginalName());
            $destinationPath = public_path('avatar_image');
            $image->move($destinationPath, $filename);
            $user->avatar = $filename;
        }

        $user->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $user->save();

        return redirect('account')->with(['flash_level' => 'success', 'flash_message' => "Cập nhật thông tin thành công!"]);
    }

    public function roomUser() {
        $roomtype = RoomType::all();

        $rooms = DB::table('room as a')
            ->join('room_type as b', 'a.type', '=', 'b.id')
            ->select('a.id', 'b.name as type', 'a.service', 'b.price', 'a.status', 'a.startday', 'a.endday', 'a.image', 'a.user_id as user', 'a.note')
            ->where('a.user_id', Auth::user()->id)
            ->paginate(3);

        foreach ($rooms as $room) {
            $serviceQuantities = json_decode($room->service, true);

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

            $currentYear = date('Y');
            $startDate = DateTime::createFromFormat('d/m/Y', $room->startday);
            $endDate = DateTime::createFromFormat('d/m/Y', $room->endday);

            if ($startDate && $endDate) {
                $startDate->setDate($startDate->format('Y'), $startDate->format('m'), $startDate->format('d'));
                $endDate->setDate($startDate->format('Y'), $endDate->format('m'), $endDate->format('d'));

                $interval = $startDate->diff($endDate);
                $roomDays = $interval->days;

                if ($roomDays == 0) {
                    $roomDays = 1;
                }

                $room->rented_days = $roomDays;
            }

            $room->image = json_decode($room->image, true);
        }

        return view('front.room-user', compact('roomtype','rooms'));
    }

    public function review_post(Request $request, $id) {
        if ($request->review == null) {
            return redirect('hotel/room/'.$id)->with(['flash_level' => 'danger', 'flash_message' => "Vui lòng nhập nội dung đánh giá!"]);
        }
        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->room_id = $id;
        $review->content = $request->review;
        $review->rating = $request->rating;
        $review->created_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $review->updated_at = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $review->save();
        return redirect('hotel/room/'.$id)->with(['flash_level' => 'success', 'flash_message' => "Đánh giá thành công!"]);
    }

    public function contact() {
        return view('front.contact');
    }

    public function payment() {
        return view('front.payment');
    }
}
