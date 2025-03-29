<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $title = 'Quản lý người dùng';
        $users = User::orderBy('created_at', 'asc')   
            ->paginate(12);
        return view('admin.users.index', compact('title', 'users'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ], [
            'username.required' => 'Vui lòng nhập tên người dùng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng nhập lại mật khẩu',
            'confirm_password.same' => 'Mật khẩu không khớp',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return redirect('/dang-nhap')->with('success', 'Đăng ký thành công');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Regenerate session for security
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công');
        } else {
            return back()->withInput($request->only('email'))->with('error', 'Email hoặc mật khẩu không đúng');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/dang-nhap');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'username.required' => 'Vui lòng nhập tên người dùng',
            'fullname.max' => 'Họ và tên không được vượt quá 255 ký tự',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'avatar.image' => 'Ảnh đại diện phải là định dạng ảnh hợp lệ',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB',
        ]);

        $user->username = $request->username;
        $user->fullname = $request->fullname;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && File::exists(public_path($user->avatar))) {
                File::delete(public_path($user->avatar));
            }

            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $avatarPath = 'avatars/' . $avatarName;
            $request->avatar->move(public_path('avatars'), $avatarName);

            $user->avatar = $avatarPath;
        }

        if ($user instanceof User) {
            if ($user instanceof User) {
                $user->save();
            } else {
                return back()->with('error', 'Không tìm thấy người dùng hợp lệ');
            }
        } else {
            return back()->with('error', 'Không tìm thấy người dùng hợp lệ');
        }

        return back()->with('success', 'Cập nhật hồ sơ thành công');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
            $user->avatar = null;
            if ($user instanceof User) {
                $user->save();
            } else {
                return back()->with('error', 'Không tìm thấy người dùng hợp lệ');
            }
        }

        return response()->json(['success' => true, 'message' => 'Xóa ảnh thành công']);
    }

    public function changePassword()
    {
        $title = "Đổi mật khẩu";
        $user = Auth::user();
        return view('change-password', compact('user', 'title'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng');
        }

        $user->password = Hash::make($request->password);

        if ($user instanceof User) {
            $user->save();
        } else {
            return back()->with('error', 'Không tìm thấy người dùng hợp lệ');
        }

        return back()->with('success', 'Đổi mật khẩu thành công');
    }

    public function forgotPassword(Request $request)
    {
        $title = 'Quên mật khẩu';
        return view('auth.forgot-password', compact('title'));
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Không tìm thấy tài khoản với email này'
        ]);

        $request->session()->forget(['email', 'otp_verified']);

        $user = User::where('email', $request->email)->first();

        $user->sendPasswordResetEmail();

        $request->session()->put('email', $request->email);

        return redirect()->route('password.verify-otp')
            ->with('success', 'Mã OTP đã được gửi đến email của bạn');
    }

    public function verifyOtp(Request $request)
    {
        $title = 'Xác nhận OTP';
        return view('auth.verify-otp', compact('title'));
    }

    public function validateOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP',
            'otp.numeric' => 'Mã OTP phải là số',
            'otp.digits' => 'Mã OTP phải có 6 chữ số'
        ]);

        $email = $request->session()->get('email');

        if (!$email) {
            return redirect()->route('password.forgot')
                ->with('error', 'Phiên làm việc đã hết hạn. Vui lòng thực hiện lại quy trình đặt lại mật khẩu.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.forgot')
                ->with('error', 'Không tìm thấy tài khoản');
        }

        if (!$user->verifyResetToken($request->otp)) {
            return redirect()->route('password.verify-otp')
                ->with('error', 'Mã OTP không hợp lệ hoặc đã hết hạn');
        }

        $request->session()->put('otp_verified', true);

        return redirect()->route('password.reset');
    }

    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.forgot');
        }

        $title = 'Đặt lại mật khẩu';
        return view('auth.reset-password', compact('title'));
    }

    public function resetPassword(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp'
        ]);

        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->clearResetToken();
            $user->save();

            $request->session()->forget(['email', 'otp_verified']);

            return redirect()->route('login')->with('success', 'Mật khẩu đã được đổi thành công. Vui lòng đăng nhập.');
        }

        return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
    }

    // Phương thức đăng nhập Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'username' => $googleUser->getName(),
                    'password' => null,
                    'oauth_provider' => 'google',
                    'oauth_id' => $googleUser->getId(),
                ]
            );

            Auth::login($user);
            return redirect()->route('home')->with('success', 'Đăng nhập Google thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi đăng nhập Google: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại.');
        }
    }

    public function updateRole(Request $request, $id)
    {
        $currentUser = Auth::user();
        $targetUser = User::findOrFail($id);

        if ($currentUser->role === 'owner') {
            if ($targetUser->role === 'owner') {
                return back()->with('error', 'Không được thao tác với owner khác');
            }
            if (!in_array($request->role, ['user', 'admin'])) {
                return back()->with('error', 'Role không hợp lệ');
            }
        } else if ($currentUser->role === 'admin') {
            if ($targetUser->role === 'owner') {
                return back()->with('error', 'Không được thao tác với owner');
            }
            if (!in_array($request->role, ['user', 'admin'])) {
                return back()->with('error', 'Role không hợp lệ');
            }
        } else {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này');
        }

        $targetUser->update(['role' => $request->role]);

        return back()->with('success', 'Cập nhật role thành công');
    }

    public function destroy($id)
    {
        $currentUser = Auth::user();
        $targetUser = User::findOrFail($id);


        if ($currentUser->role === 'owner') {
            if ($targetUser->id === $currentUser->id) {
                return back()->with('error', 'Không thể xóa chính mình');
            }
            if ($targetUser->role === 'owner') {
                return back()->with('error', 'Không thể xóa owner khác');
            }
        } else if ($currentUser->role === 'admin') {
            if ($targetUser->role !== 'user') {
                return back()->with('error', 'Bạn chỉ được xóa user thường');
            }
        } else {
            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này');
        }

        $targetUser->delete();
        return back()->with('success', 'Xóa người dùng thành công');
    }
}
