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
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<a href="'.asset('storage/' . $row->image).'" data-fancybox="gallery" data-caption="'.$row->title.'">
                                <img src="'.asset('storage/images/thumbnails/' . basename($row->image)).'" alt="'.$row->title.'" style="width: 50px; height: auto;">
                            </a>';
                } else {
                    return '<p>No image available</p>';
                }
            })
            ->addColumn('action', function ($row) {
                $actions = '<a href="'.route('user.show', $row->id).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="'.route('user.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';

                if (auth()->id() !== $row->id) {
                    $actions .= '<form id="deleteForm-user-'.$row->id.'" action="'.route('user.destroy', $row->id).'" method="POST" style="display:inline;">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete(\'deleteForm-user-'.$row->id.'\')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>';
                }
                return $actions;
            })
            ->rawColumns(['action', 'image']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
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
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            'action',
            'name',
            'email',
            'image',
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
