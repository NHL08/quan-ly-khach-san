<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Room; // Thêm model Room nếu bạn đang sử dụng Eloquent để làm việc với database

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy room_id từ request
        $roomId = $request->route('id'); // route parameter 'id'

        // Tìm phòng dựa trên ID
        $room = Room::find($roomId);

        if(auth()->user()) {
            return $next($request);
        } else {
            return redirect('login');
        }

        // Kiểm tra nếu phòng tồn tại và status lớn hơn 1
        if ($room && $room->status >= 1) {
            return redirect('hotel');
        }

        // Nếu phòng không tồn tại hoặc status không lớn hơn 1, trả về redirect hoặc error response
        return $next($request);
    }
}
