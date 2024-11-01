<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StudentDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\PurchaseHistory;
use App\Services\StudentService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class StudentController extends Controller
{
    protected $studentService;
    protected $userService;
    public function __construct(StudentService $studentService, UserService $userService)
    {
        $this->studentService   = $studentService;
        $this->userService      = $userService;

    }

    /**
     * Define middleware for the controller.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('List Student'), only: ['index']),
            new Middleware(PermissionMiddleware::using('Add Student'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('Edit Student'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('Delete Student'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('Restore Student'), only: ['restore']),
        ];
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $dataTable = new StudentDataTable($data);
        setPageMeta(__('List Student'));

        return $dataTable->render('common.datatable');
    }
    public function create()
    {
        setPageMeta(__('Add Student'));
        return view('admin.students.create');
    }

    public function store(StudentRequest $request) // Use Request class
    {
        try {
            $this->studentService->createOrUpdate($request);

            sendFlash(__('Successfully created'));
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }
    public function edit($id)
    {
        setPageMeta(__('Edit Student'));
        $user = $this->userService->getWithTrashed($id, ['studentProfile'=>function($q){
            $q->withTrashed();
        }]);
        return view('admin.students.edit', compact('user'));
    }

    public function update(StudentRequest $request, $id)
    {
        try {
            $this->studentService->createOrUpdate($request, $id);

            sendFlash(__('Successfully Updated'));
            return redirect()->route('students.index');
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteForceDeleteModel($id);
            sendFlash(__('Successfully Deleted'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }
    public function restore($id)
    {
        try {
            $user = $this->userService->getWithTrashed($id, ['studentProfile'=>function($q){
                $q->withTrashed();
            }]);

            $this->userService->restore($id);
            $this->studentService->restore($user->studentProfile->id);
            sendFlash(__('Successfully Restored'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }

    public function enrollCourseByCash(Request $request)
    {
        try {
            $request->validate([
                'course_id'     => 'required|exists:courses,id',
                'user_id'       => 'required|exists:users,id',
            ]);

            $purchase_course_ids = PurchaseHistory::where('user_id',$request->user_id)->pluck('course_id')->toArray();

            if(in_array($request->course_id, $purchase_course_ids)){
                sendFlash(__('Already enrolled this course'), 'error');
                return back();
            }

            $this->studentService->enrollCourseByCash($request);
            sendFlash(__('Successfully Enrolled'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }
}
