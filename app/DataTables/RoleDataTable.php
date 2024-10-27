<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Services\DataTable;
use PDF;

class RoleDataTable extends DataTable
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
            ->addColumn('action', function ($role) {
                $buttons = '';
                $buttons .= '<a class="btn btn-primary btn-circle waves-effect waves-float ml-2" href="' . route('roles.edit', $role->id) . '" title="Edit"><i class="fas fa-edit"></i></a>';

                $buttons .= '<form action="' . route('roles.destroy', $role->id) . '"  id="delete-form-' . $role->id . '" method="post" style="display: inline-block">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn bg-danger text-white btn-circle waves-effect waves-float mx-1" onclick="return makeDeleteRequest(event, ' . $role->id . ')"  type="submit" title="Delete"><i class="fas fa-trash-alt"></i></form>
                                ';
                return $buttons;
            })
            ->editColumn('created_at', function ($role) {
                return $role->created_at->format('d M Y');
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {
        return $model->latest()->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => 'auto', 'printable' => false, 'title' => 'Action'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'defaultContent' => '',
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'title' => '#SL',
                'render' => null,
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'footer' => '',
            ],
            [
                'title' => 'NAME',
                'name' => 'name',
                'data' => 'name'
            ],
            [
                'title' => 'Created At',
                'name' => 'created_at',
                'data' => 'created_at'
            ],
        ];

    }

    protected function getCustomFilename()
    {
        return 'Role_' . date('YmdHis');
    }

    public function pdf()
    {
        $excel = app('excel');
        $data = $this->getDataForExport();

        $pdf = PDF::loadView('vendor.datatables.print', [
            'data' => $data
        ]);
        return $pdf->download($this->getCustomFilename() . '.pdf');
    }

}
