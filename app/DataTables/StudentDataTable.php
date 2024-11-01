<?php

namespace App\DataTables;

use PDF;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\StudentProfile;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public function dataTable($query)
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
//                    data-url="' . route('load-modal', ['page_name' => 'enroll-course','param1' => $student->user->id]) . '"
//                    data-title="' . __('Enroll Course') . '"
//                    data-bs-toggle="modal"
//                    data-bs-target="#common-modal"
//                    href="javascript:void(0)"
//                    title="Edit"><i class="mdi mdi-square-circle"></i>' . __('Enroll Course') . '</a></li>';
//
//                }
                if (auth()->user()->can('Delete Student') && auth()->id() != $student->id) {
                    $button_text = $student->user->deleted_at != null ? 'Permanent Delete' : 'Delete';
                        $buttons .= '<form action="' . route('students.destroy', $student->user->id) . '"  id="delete-form-' . $student->user->id . '" method="post">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="dropdown-item text-danger delete-list-data" onclick="return makeDeleteRequest(event, ' . $student->user->id . ')" data-from-name="'. $student->user->first_name.'" data-from-id="' . $student->user->id . '"   type="button" title="Delete"><i class="mdi mdi-trash-can-outline"></i> ' . $button_text . '</button></form>
                    ';
                }
                if (auth()->user()->can('Restore Student') && auth()->id() != $student->id && $student->user->deleted_at != null) {
                        $buttons .= '<form action="' . route('students.restore', $student->user->id) . '"  id="restore-form-' . $student->user->id . '" method="post">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="PUT">
                    <button class="dropdown-item text-info restore-list-data" onclick="return makeRestoreRequest(event, ' . $student->user->id . ')" data-from-name="'. $student->user->first_name.'" data-from-id="' . $student->user->id . '"   type="button" title="Restore"><i class="mdi mdi-restore"></i> ' . __('Restore') . '</button></form>
                    ';
                }
                return '<div class="btn-group dropstart">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </button>
                          <ul class="dropdown-menu">
                            '   . $buttons .'
                          </ul>
                        </div>';

            })->editColumn('user.avatar', function ($student) {
                return '<img class="ic-list-img" src="' . getStorageImage($student->user->avatar,true) . '" alt="' . $student->name . '" />';
            })
            ->escapeColumns([])
            ->editColumn('user.status', function ($student) {
                $badge = $student->user->deleted_at != null ? "bg-danger" :( $student->user->status == User::STATUS_ACTIVE ? "bg-success" : "bg-warning");
                $status = $student->user->deleted_at != null ? __("DELETED") : Str::upper( $student->user->status);
                return '<span class="badge ' . $badge . '">' . $status . '</span>';

            })
            ->editColumn('address', function ($student) {
                return Str::limit($student->address, 30, '...');
            })
            ->editColumn('bulk-select', function ($category) {

                return '<input class="form-check-input ic-item-select-checkbox" type="checkbox" data-id="'.$category->id.'"/>';

            })
            ->editColumn('created_at', function ($student) {
                return $student->created_at->format('d M Y h:i A');
            })->rawColumns(['bulk-select','avatar', 'status','created_at', 'action'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StudentProfile $model)
    {
        return $model->newQuery()->with(['user'=> fn($q) => $q->withTrashed()])
            ->whereHas('user', function ($query) {
                $query->where('type', User::TYPE_STUDENT);
                $query->withTrashed();
            })->withTrashed();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $params             = $this->getBuilderParameters();
        $params['order']    = [[3, 'asc']];
        $params['dom']          = "Bfrtilp";
        $params['lengthChange'] = true;
        $params['info']         = false;
        $params['lengthMenu']   = [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']];

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '55px', 'class' => 'text-center', 'printable' => false, 'exportable' => false, 'title' => 'Action'])
            ->parameters($params)
            ->buttons([
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('delete')->action($this->deleteActionBtn()),
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('bulk-select', '<input class="form-check-input select-all-checkbox" type="checkbox"/>')->width('5px')->orderable(false)->searchable(false)->printable(false)->exportable(false),
            Column::computed('DT_RowIndex', __('SL')),
            Column::make('user.avatar', 'user.avatar')->title(__('Avatar')),
            Column::make('user.first_name', 'user.first_name')->title(__('First Name')),
            Column::make('user.last_name', 'user.last_name')->title(__('Last Name')),
            Column::make('user.email', 'user.email')->title(__('Email')),
            Column::make('user.phone', 'user.phone')->title(__('Phone')),
            Column::make('user.status', 'user.status')->title(__('Status')),
            Column::make('address', 'address')->title(__('Address')),
            Column::make('created_at', 'user.created_at')->title(__('Created At')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Student_' . date('YmdHis');
    }

    /**
     * pdf
     *
     * @return void
     */
    public function pdf()
    {
        $data = $this->getDataForExport();

        $pdf = PDF::loadView('vendor.datatables.print', [
            'data' => $data
        ]);
        return $pdf->download($this->getFilename() . '.pdf');
    }

    protected function deleteActionBtn()
    {
        $actionUrl = route('users.bulk-destroy');
        return "makeDeleteBulkRequest(event,'bulk-delete', '".$actionUrl."')";

    }
}
