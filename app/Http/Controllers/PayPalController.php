<?php

namespace App\Http\Controllers;

use App\Models\CourseCode;
use App\Models\Courses;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\LoginNotification;
use App\Traits\Api\OrderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nafezly\Payments\Classes\PaymobPayment;
use Nafezly\Payments\Classes\PaymobWalletPayment;

class PayPalController extends Controller
{

    public function payWithPaymob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total' => 'required|numeric|min:0',
            'phone' => 'required|string|min:10|max:15',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'coin' => 'required|string|in:USD,EGP',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::find($request->user_id);
        $total = $request->total;
        $phone = $request->phone;
        $course_id = $request->course_id;
        $course = Courses::find($course_id);
        $payment = new PaymobPayment();
        $response = $payment
            ->setUserFirstName($user->firstname ?? "test")
            ->setUserLastName($user->lastname ?? "test")
            ->setUserEmail($user->email ?? "test@gmail.com")
            ->setUserPhone($phone)
            ->setAmount($total)
            ->pay();

        $paymentTable = new Payment();
        $paymentTable->user_id = $user->id;
        $paymentTable->course_id = $course_id;
        $paymentTable->instructor_id = $course->created_by ?? 1;
        $paymentTable->amount = $total;
        $paymentTable->total = $total;
        $paymentTable->payment_id = $response['payment_id'];
        $paymentTable->status = false;
        $paymentTable->currency = $request->coin;
        $paymentTable->phone = $phone;
        $paymentTable->save();
        return  response()->json($response);
    }

    public function verifyWithPaymob(Request $request)
    {
        $payment = new PaymobPayment();
        $response = $payment->verify($request);
        if ($response['success'] == true) {
            $paymentTable = Payment::where('payment_id', $response['payment_id'])->first();
            $code = new CourseCode();
            $code->code = $this->generateUniqueCode(); // Generate a unique code
            $code->created_at = now();
            $code->expires_at = now()->addMonths(6); // Add 6 months to the current date
            $code->course_id = $paymentTable->course_id;
            $code->user_id = $paymentTable->user_id;
            $code->is_used = true;
            $code->save();
            $user = User::find($paymentTable->user_id);
            $user->notify(new LoginNotification());
            return redirect("https://adrenaline-edu.com/success");
        }
        return redirect("https://adrenaline-edu.com/failed");
    }


    public function payWithPaymobWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total' => 'required|numeric|min:0',
            'phone' => 'required|string|min:10|max:15',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'coin' => 'required|string|in:USD,EGP',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::find($request->user_id);
        $total = $request->total;
        $phone = $request->phone;
        $course_id = $request->course_id;
        $payment = new PaymobWalletPayment();
        $response = $payment
            ->setUserFirstName($user->firstname . $user->lastname ?? "test")
            ->setUserLastName($course_id . '-' . $user->id . '-' . $phone . '-' . $total)
            ->setUserEmail($user->email)
            ->setUserPhone($phone) // $user->phone ??
            ->setAmount($total)
            ->pay();
        return  response()->json($response);
    }

    public function verifyWithPaymobWallet(Request $request)
    {
        $payment = new PaymobWalletPayment();
        $response = $payment->verify($request);
        if ($response['success'] == true) {
            $parts = explode("-", $response['process_data']['customer']['last_name']);
            $firstName = $parts[0];
            $middleName = $parts[1];
            $lastName = $parts[2];
            $code = new CourseCode();
            $code->code = $this->generateUniqueCode(); // Generate a unique code
            $code->created_at = now();
            $code->expires_at = now()->addMonths(6); // Add 6 months to the current date
            $code->course_id = $firstName;
            $code->user_id = $middleName;
            $code->is_used = true;
            $code->save();
            $user = User::find($middleName);
            $user->notify(new LoginNotification());
            return response()->json("Payment completed successfully");
        }
        return response()->json("Payment failed");
    }
    protected function generateUniqueCode()
    {
        $length = 8; // Set the desired code length
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        // Check if the generated code already exists in the database
        while (CourseCode::where('code', $randomString)->exists()) {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
        }

        return $randomString;
    }
}