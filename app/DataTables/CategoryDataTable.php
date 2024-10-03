<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
            ->rawColumns(['action','title','image','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    private function renderImageColumn($row): string
    {
        if ($row->image) {
            return '<a href="'.asset('storage/' . $row->image).'" data-fancybox="gallery" data-caption="'.$row->title.'">
                        <img src="'.asset('storage/images/thumbnails/100px/' . basename($row->image)).'" alt="'.$row->title.'" style=" width:80px; height: auto;">
                    </a>';
        }
        return '<p>No image available</p>';
    }

    private function renderActionColumn($row): string
    {
        return '
            <a href="'.route('news-category.show', $row->id).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
            <a href="'.route('news-category.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            <form id="deleteForm-category-'.$row->id.'" action="'.route('news-category.destroy', $row->id).'" method="POST" style="display:inline;">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete(\'deleteForm-category-'.$row->id.'\')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>';
    }

    private function renderStatusColumn($row): string
    {
        return '
            <div class="form-check form-switch">
                <input class="form-check-input status-toggle" type="checkbox" data-id="'.$row->id.'" '.($row->status ? 'checked' : '').'>
                <label class="form-check-label" for="statusLabel'.$row->id.'"></label>
            </div>';
    }
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip')
                    ->orderBy(1);

    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('action')
                ->width(100),

            Column::make('name')
                ->width(200),

            Column::make('image')
                ->width(100),

            Column::make('status')
                ->width(80),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
