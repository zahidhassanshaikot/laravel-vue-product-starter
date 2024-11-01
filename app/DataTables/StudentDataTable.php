<?php

namespace App\DataTables;

use App\Models\StudentProfile;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use PDF;

/**
 * Class StudentDataTable
 *
 * @package App\Http\Controllers\Admin
 */
class StudentDataTable extends DataTable
{
    public $status;
    public function __construct($request)
    {
        $this->status = $request['status']??'';
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     * @throws Exception
     */
    public function dataTable(mixed $query): DataTableAbstract
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($student) {
                $buttons = '';
                if (auth()->user()->can('Edit Student')) {
                    $buttons .= '<li><a class="dropdown-item" href="' . route('students.edit', $student->user->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i>' . __('Edit') . '</a></li>';
                }
//                if (auth()->user()->can('Enroll Course')) {
//                    $buttons .= '<li><a class="dropdown-item modal-menu"
//                    data-url="' . route('load-modal', ['page_name' => 'enroll-course', 'param1' => $student->user->id]) . '"
//                    data-title="' . __('Enroll Course') . '"
//                    data-bs-toggle="modal"
//                    data-bs-target="#common-modal"
//                    href="javascript:void(0)"
//                    title="Edit"><i class="mdi mdi-square-circle me-1"></i>' . __('Enroll Course') . '</a></li>';
//                }
//                if (auth()->user()->can('Enrolled Course List')) {
//                    $buttons .= '<li><a class="dropdown-item" href="' . route('students.course.enrolled.index', $student->user->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i>' . __('Enrolled Course List') . '</a></li>';
//                }

                if (auth()->user()->can('Delete Student') && auth()->id() != $student->user_id) {
                    $button_text = $student->user->deleted_at != null ? 'Permanent Delete' : 'Delete';
                    $buttons .= '<form action="' . route('students.destroy', $student->user->id) . '"  id="delete-form-' . $student->user->id . '" method="post">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="dropdown-item text-danger delete-list-data" onclick="return makeDeleteRequest(event, ' . $student->user->id . ')" data-from-name="' . $student->user->first_name . '" data-from-id="' . $student->user->id . '"   type="button" title="Delete"><i class="mdi mdi-trash-can-outline"></i> ' . $button_text . '</button></form>
                    ';
                }
                if (auth()->user()->can('Restore Student') && auth()->id() != $student->user_id && $student->user->deleted_at != null) {
                    $buttons .= '<form action="' . route('students.restore', $student->user->id) . '"  id="restore-form-' . $student->user->id . '" method="post">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="PUT">
                    <button class="dropdown-item text-info restore-list-data" onclick="return makeRestoreRequest(event, ' . $student->user->id . ')" data-from-name="' . $student->user->first_name . '" data-from-id="' . $student->user->id . '"   type="button" title="Restore"><i class="mdi mdi-restore"></i> ' . __('Restore') . '</button></form>
                    ';
                }
                return '<div class="btn-group dropstart">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </button>
                          <ul class="dropdown-menu">
                            ' . $buttons . '
                          </ul>
                        </div>';

            })->editColumn('user.avatar', function ($student) {
                return '<img class="ic-list-img" src="' . getStorageImage($student->user->avatar, true) . '" alt="' . $student->name . '" />';
            })
            ->escapeColumns([])
            ->editColumn('user.status', function ($student) {
//                $badge = $student->user->deleted_at != null ? "bg-danger" :( $student->user->status == User::STATUS_ACTIVE ? "bg-success" : "bg-warning");
                $status = $student->user->deleted_at != null ? __("DELETED") : Str::upper($student->user->status);
//                return '<span class="badge ' . $badge . '">' . $status . '</span>';

                //toggle status
                $id = $student->user->id;
                $model = User::class;
                $column = "status";
                $checked = $student->user->status == User::STATUS_ACTIVE ? "checked" : "";
                $route = route('common.status-change', $id);
                $value = $student->user->status == User::STATUS_ACTIVE ? User::STATUS_INACTIVE : User::STATUS_ACTIVE;
                $altValue = $student->user->status == User::STATUS_ACTIVE ? User::STATUS_ACTIVE : User::STATUS_INACTIVE;
                $disabled = auth()->user()->can('Edit Student') ? '' : 'disabled';

                return toggleClass($disabled, $checked, $model, $column, $id, $route, $value, $altValue);
            })
            ->editColumn('address', function ($student) {
                return Str::limit($student->address, 30, '...');
            })
            ->addColumn('bulk_select', function ($row) {

                return '<input class="form-check-input ic-item-select-checkbox" type="checkbox" data-id="' . $row->user_id . '"/>';

            })
            ->editColumn('created_at', function ($student) {
                return $student->created_at->format('d M Y h:i A');
            })->rawColumns(['bulk_select', 'avatar', 'status', 'created_at', 'action'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * StudentProfile $model
     * @return builder
     */
    public function query(StudentProfile $model): Builder
    {
        return $model->newQuery()
            ->with([
                'user' => fn($q) => $q->withTrashed()
            ])
            ->when($this->status, function ($q) {
                return $q->whereHas('user', function ($q) {
                    $q->where('status', $this->status);
                });
            })
            ->whereHas('user', function ($query) {
                $query->where('type', User::TYPE_STUDENT)
                    ->withTrashed();
            })->withTrashed();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
//        $actionUrl = route('users.bulk-status-change');

        $actionUrl = route('common.bulk-status-change');
        $model = json_encode(User::class);

        $student_status = route('students.index');

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '55px', 'class' => 'text-center', 'printable' => false, 'exportable' => false, 'title' => 'ACTION'])
            ->parameters([
                'dom'     => 'Bfrtilp',
                'order'   => [[0, 'desc']],
                'lengthMenu' => [[25,50, 100, 200, 300, -1], [25,50, 100, 200, 300, 'All']],
                'buttons' => [
                    'create',
                    'export',
                    'print',
                ],
            ])
            ->buttons([
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('delete')->action($this->deleteActionBtn()),
                // Add the new button for changing status
                [
                    'text' => 'Change',
                    "extend" => 'collection',
                    'className' => 'buttons-reload',
                    "buttons" => [
                        [
                            'text' => 'Make Active',
                            'className' => 'buttons-print',
                            'action' => "function() { changeBulkStatus(event, '$actionUrl', 'active',$model); }",
                        ],
                        [
                            'text' => 'Make InActive',
                            'className' => 'buttons-pdf',
                            'action' => "function() { changeBulkStatus(event, '$actionUrl', 'inactive',$model); }",
                        ],
                    ],

                ],
                [
                    'text' => 'Filter By',
                    "extend" => 'collection',
                    'className' => 'buttons-reload',
                    "buttons" => [
                        [
                            'text' => 'Active',
                            'className' => 'buttons-print',
                            'action' => "function() { getStatus(event, '$student_status?status=active'); }",
                        ],
                        [
                            'text' => 'InActive',
                            'className' => 'buttons-pdf',
                            'action' => "function() { getStatus(event, '$student_status?status=inactive'); }",
                        ],
                        [
                            'text' => 'All',
                            'className' => 'buttons-pdf',
                            'action' => "function() { getStatus(event, '$student_status'); }",
                        ],
                    ],

                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            [
                'title' => 'ID',
                'name' => 'id',
                'data' => 'id',
                'visible' => false,
                'exportable' => false,
                'printable' => false,
            ],
            [
                'title' => '<input class="form-check-input select-all-checkbox" type="checkbox"/>',
                'name' => 'bulk_select',
                'data' => 'bulk_select',
                'defaultContent' => '',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
            ],
            [
                'defaultContent' => '',
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'title' => __('SL'),
                'render' => null,
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => true,
                'footer' => '',
            ],
            [
                'data' => 'user.avatar',
                'name' => 'user.avatar',
                'title' => __('AVATAR'),
            ],
            [
                'data' => 'user.first_name',
                'name' => 'user.first_name',
                'title' => __('FIRST NAME'),
            ],
            [
                'data' => 'user.last_name',
                'name' => 'user.last_name',
                'title' => __('LAST NAME'),
            ],
            [
                'data' => 'user.email',
                'name' => 'user.email',
                'title' => __('EMAIL'),
            ],
            [
                'data' => 'user.phone',
                'name' => 'user.phone',
                'title' => __('PHONE'),
            ],
            [
                'data' => 'user.status',
                'name' => 'user.status',
                'title' => __('STATUS'),
            ],
            [
                'data' => 'address',
                'name' => 'address',
                'title' => __('ADDRESS'),
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => __('CREATED AT'),
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'student_' . date('YmdHis');
    }

    /**
     * pdf
     *
     * @return mixed
     */
    public function pdf(): mixed
    {
        $data = $this->getDataForExport();

        $pdf = PDF::loadView('vendor.datatables.print', [
            'data' => $data
        ])->setPaper('a4', 'landscape');
        return $pdf->download($this->getFilename() . '.pdf');
    }

    /**
     * Generate action URL for delete button.
     *
     * @return string
     */
    protected function deleteActionBtn(): string
    {
        $actionUrl      = route('common.bulk-destroy');
        $service_class  = json_encode(UserService::class);
        $method_name    = json_encode('deleteForceDeleteModel');

        return "makeDeleteBulkRequest(event,'bulk-delete', '" . $actionUrl . "', $service_class, $method_name)";


    }
}
