<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', fn($row) => $this->renderImageColumn($row))
            ->addColumn('action', fn($row) => $this->renderActionColumn($row))
            ->editColumn('status', fn($row) => $this->renderStatusColumn($row))

            ->rawColumns(['action', 'status', 'image']);
    }

    private function renderImageColumn($row): string
    {
        return $row->image
            ? '<a href="'.asset('storage/images/thumbnails/800px_' . basename($row->image)).'" data-fancybox="gallery" data-caption="'.$row->name.'">
                   <img src="'.asset('storage/images/thumbnails/100px_' . basename($row->image)).'" alt="'.$row->name.'" style=" width:80px; height: auto;">
               </a>'
            : '<p>No image available</p>';
    }

    private function renderActionColumn($row): string
    {
        // Action buttons for viewing and editing the user
        $actions = '<a href="'.route('user.show', $row->id).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                    <a href="'.route('user.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';

        // Only show delete button if the user is not the currently authenticated user
        if (auth()->id() !== $row->id) {
            $actions .= '<form id="deleteForm-user-'.$row->id.'" action="'.route('user.destroy', $row->id).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete(\'deleteForm-user-'.$row->id.'\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';
        }

        // The password button now comes after the delete form
        $actions .= '<a href="'.route('password', $row->id).'" class="btn btn-secondary btn-sm">
                        <i class="fas fa-lock"></i>
                    </a>';

        return $actions;
    }


    private function renderStatusColumn($row): string
    {
        // If the authenticated user is the same as the current row, display status as plain text
        if (auth()->check() && auth()->id() === $row->id) {
            return '<span style="color: #fff; background-color: '.($row->status ? '#28a745' : '#dc3545').'" class="badge '.($row->status ? 'badge-success' : 'badge-danger').'">'
                .($row->status ? 'Active' : 'Inactive').'</span>';
        }

        // Otherwise, display the toggle switch
        $checked = $row->status ? 'checked' : '';
        $disabled = (auth()->check() && auth()->user()->status && auth()->id() === $row->id) ? 'disabled' : '';

        return '
            <div class="form-check form-switch">
                <input class="form-check-input status-toggle" type="checkbox" id="status'.$row->id.'" data-id="'.$row->id.'" '.$checked.' '.$disabled.'>
                <label class="form-check-label" for="status'.$row->id.'"></label>
            </div>';
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('ftiprl')
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('action')
                ->width(100), // Fixed width for action column
            Column::make('name'),
            Column::make('email')
                ->width(250),
            Column::make('image')
                ->width(150),
            Column::make('phone')
                ->width(100),
            Column::make('status')
                ->width(50),   // Fixed width for status column
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
