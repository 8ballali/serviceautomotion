<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Product;
use App\Models\StatusBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class BookingController extends Controller
{
    public function index()
    {
        $booking = Booking::get();
        $status = StatusBooking::get();
        $employee = Employee::get();
        $department = Department::all();
        $logged_in = Auth::id();
        if (Auth::user()->role_id == 1) {
            $roles = Auth::user()->roles->name;
            $name = $roles;
        }else {
            $employee_name = Employee::where('user_id', $logged_in)->select('name')->get();
            $name = $employee_name[0]->name;
        }
        return view('admin.booking', compact('booking','employee','department', 'name', 'status'));
    }
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        $status_booking = StatusBooking::where('name','DITERIMA')->first();
        $product = Product::find($booking->product_id)->first();
        if ($request->status == $status_booking->id) {
            $product->status = 'Booked';
        }
        $booking->status = $request->status;
        $booking->save();
        $product->save();
        return redirect('/booking');
    }
    public function download ($booking_id)
    {
        $download = Booking::find($booking_id);
        $pathFile = storage_path('app\public/'. $download->bukti);

        return response()->download($pathFile);
    }
    public function exportPDF()
    {
        $booking = Booking::all();
        $status = StatusBooking::get();
        $employee = Employee::get();
        $department = Department::all();
        $pdf = PDF::loadView('admin.booking-pdf', ['booking' => $booking, 'employee' => $employee, 'department' => $department,'status' => $status]);
        return $pdf->download('cetak-booking.pdf');
    }
}
