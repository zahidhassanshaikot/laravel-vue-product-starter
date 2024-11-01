<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseInfo;
use App\Models\PurchaseHistory;
use App\Models\StudentProfile;
use App\Models\StudentProgress;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Storage;
use PDF;
class StudentService extends BaseService
{
//    protected $fileUploadService;
    protected $userService;

    public function __construct(StudentProfile $model, UserService $userService)
    {
        parent::__construct($model);
//        $this->fileUploadService = $fileUploadService;
        $this->userService = $userService;

    }
    public function createOrUpdate($request, int $id = null): mixed
    {
        $data           = $request->all();
        if ($id) {
            // Update
            $user           = $this->userService->getWithTrashed($id, ['studentProfile'=>function($q){
                $q->withTrashed();
            }]);
            $userProfile    = $this->getWithTrashed($user->studentProfile->id);
            // Password
            if (isset($data['password']) && $data['password']) {
                $user->password = Hash::make($data['password']);
            }

            // Avatar
            if (isset($data['avatar']) && $data['avatar'] != null) {
                $user->avatar = $this->fileUploadService->uploadFile($request,'avatar',User::FILE_STORE_PATH,$user->avatar);
            }
            $user->first_name       = $data['first_name'];
            $user->last_name        = $data['last_name'];
            $user->email            = $data['email'];
            $user->phone            = $data['phone'];
            $user->gender           = $data['gender'];
            $user->type             = User::TYPE_STUDENT;
            $user->status           = $data['status'];
            $user->updated_by       = Auth::id();

            // Update user
            $user->save();

            $userProfile->update($data);

            return $user;
        } else {
            // Create
            $data['password']        = Hash::make($data['password']);
            if (isset($data['avatar']) && $data['avatar'] != null) {
                $data['avatar']      = $this->fileUploadService->uploadFile($request,'avatar',User::FILE_STORE_PATH,);
            }
            $data['created_by']         = Auth::id();
            $data['type']               = User::TYPE_STUDENT;
            // Store user
            $user                       = User::create($data);
            $data['user_id']            = $user->id;
            $studentProfile             = StudentProfile::create($data);

            return $studentProfile ;

        }
    }

    public function updatePersonalDetails($request){
        $data           = $request->all();
        $user           = $this->userService->getWithTrashed(auth()->user()->id,['studentProfile'=>function($q){
            $q->withTrashed();
        }]);
        // Password
        if (isset($data['password']) && $data['password']) {
            $user->password = Hash::make($data['password']);
        }

        // Avatar
        if (isset($data['avatar']) && $data['avatar'] != null) {
            $user->avatar = $this->fileUploadService->uploadFile($request,'avatar',User::FILE_STORE_PATH,$user->avatar);
        }
        $user->first_name       = $data['first_name'];
        $user->last_name        = $data['last_name'];
        $user->email            = $data['email'];
        $user->phone            = $data['phone'];
        if(isset($data['gender'])){
            $user->gender           = $data['gender'];
        }
        $user->type             = User::TYPE_STUDENT;
        $user->status           = User::STATUS_ACTIVE;
        $user->updated_by       = Auth::id();

        // Update user
        $user->save();

        $userProfile    = $this->getWithTrashed($user->studentProfile->id);

        $userProfile->update($data);
        return $userProfile;
    }
    public function updateAvatar($request){
        $data           = $request->all();
        $user           = $this->userService->get(auth()->user()->id);
        // Avatar
        if (isset($data['avatar']) && $data['avatar'] != null) {
            $user->avatar = $this->fileUploadService->uploadFile($request,'avatar',User::FILE_STORE_PATH,$user->avatar);
        }
        $user->updated_by       = Auth::id();

        // Update user
        $user->save();

        return $user;
    }
    public function updatePassword($request){
        $data           = $request->all();
        $user           = $this->userService->get(auth()->user()->id);
        // Password
        if (isset($data['password']) && $data['password']) {
            $user->password = Hash::make($data['password']);
        }
        $user->updated_by       = Auth::id();

        // Update user
        $user->save();

        return $user;
    }
    public function deleteProfile($id)
    {
        $user       = $this->userService->get($id,['studentProfile'=>function($q){
            $q->withTrashed();
        }]);
        $student    = $this->get($user->studentProfile->id);

        $user->tokens()->delete();
        $user->delete();
        $student->delete();
        return $user;
    }
//    public function purchaseHistory($user_id){
//        return PurchaseHistory::with(['course'])->where('user_id',$user_id)->get();
//    }
//    public function myCourses($user_id){
//        try {
//            $purchase_course_ids = PurchaseHistory::where('user_id',$user_id)->pluck('course_id')->toArray();
//
//            $courses = Course::with(['purchaseHistory','activeLessons','courseInfo'])->whereIn('id', $purchase_course_ids)->get();
//            return $courses;
//        } catch (\Throwable $th) {
//            return $th;
//        }
//    }
//
//    public function enrollCourseByCash($request){
//        $data = $request->all();
//
//        $course                             = Course::find($data['course_id']);
//        $purchaseHistory                    = new PurchaseHistory();
//        $purchaseHistory->user_id           = $data['user_id'];
////        $purchaseHistory->transaction_id    = $trans->id;
//        $purchaseHistory->course_id         = $course->id;
//        $purchaseHistory->is_ged_course     = $course->course_category_id == 1 ? 1 : 0;
//        $purchaseHistory->payment_method    = PurchaseHistory::PAYMENT_METHOD_CASH;
//        $purchaseHistory->payment_info      = [
//            'payment_method'    => PurchaseHistory::PAYMENT_METHOD_CASH,
//            'payment_status'    => PurchaseHistory::PAYMENT_STATUS_PAID,
//            'payment_date'      => now(),
//            'payment_amount'    => $course->price,
//            'payment_currency'  => config('app.currency', 'BDT'),
//            'payment_type'      => 'cash',
//            'payment_note'      => 'Cash payment',
//        ];
////        $purchaseHistory->billing_address   = @$trans['billing_info'];
//        $purchaseHistory->payment_status    = PurchaseHistory::PAYMENT_STATUS_PAID;
//        $purchaseHistory->price             = $course->price;
//        $discount                           = $course->discount_type == Course::DISCOUNT_PERCENT ? (($course->price * $course->discount)/100) : $course->discount;
//        $purchaseHistory->discount          = $discount;
//        $purchaseHistory->total_paid        = $course->price - $discount;
//        $purchaseHistory->date              = now();
//        $purchaseHistory->enrollment_key    = uuid_create();
//
//        $purchaseHistory->save();
//
//        $courseInfo                         = CourseInfo::where('course_id', $course->id)->first();
//        $courseInfo->student_count          = $courseInfo->student_count + 1;
//        $courseInfo->save();
//
//    }
//
//    public function downloadCertificate($userId, $courseId)
//    {
//        $parchase           = PurchaseHistory::where('user_id', $userId)->where('course_id', $courseId)->with('user', 'course')->first();
//        $fileName           = $parchase->user->full_name ?? 'certificate';
//        $nameOfCertificate  = $fileName.".pdf";
//        $fileName           = "{$fileName}-{$parchase->enrollment_key}.pdf";
//        // $fileNameWithExt    = "{$fileName}.pdf";
//        $fileNameWithExt    = $fileName;
//        $path               = "certificate/". $fileNameWithExt;
//        $studentProgress    = StudentProgress::where('student_id', $userId)
//            ->where('course_id', $courseId)
//            ->where('is_completed', true)->first();
//
//        if(!Storage::exists($path)) {
//            $data = [
//                'profile_image'     => @$parchase->user->avatar_url,
//                'user'              => @$parchase->user,
//                'course'            => @$parchase->course,
//                'studentProgress'   => @$studentProgress,
//                'fileName'          => $fileName,
//                'bg_image'          => asset('images/default/bg.png'),
//            ];
//            $pdf            = PDF::loadView('certificate.index', $data);
//            $content        = $pdf->setPaper('a4', 'landscape')->download()->getOriginalContent();
//
//            Storage::put($path,$content);
//        }
//
//
//        $userCertificate    = public_path('storage/'.$path);
//    	$headers            = ['Content-Type: application/pdf'];
//
//        return response()->download($userCertificate, $nameOfCertificate, $headers);
//    }




}
