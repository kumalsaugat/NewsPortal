<?php

namespace App\DataTables;

use App\Models\Album;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AlbumDataTable extends DataTable
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
            ->rawColumns(['action','image','status']);
    }
    private function renderImageColumn($row): string
    {
        return $row->image
            ? '<a href="'.asset('storage/images/thumbnails/800px_' . basename($row->image)).'" data-fancybox="gallery" data-caption="'.$row->title.'">
                   <img src="'.asset('storage/images/thumbnails/100px_' . basename($row->image)).'" alt="'.$row->title.'" style=" width:80px; height: auto;">
               </a>'
            : '<p>No image available</p>';
    }
    private function renderActionColumn($row): string
    {
        return '
            <a href="'.route('album.show', $row->id).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
            <a href="'.route('album.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
            <a href="'.route('album.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-images"></i></a>
            <form id="deleteForm-album-'.$row->id.'" action="'.route('album.destroy', $row->id).'" method="POST" style="display:inline;">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete(\'deleteForm-album-'.$row->id.'\')">
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

    /**
     * Get the query source of dataTable.
     */
    public function query(Album $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('album-table')
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
                ->title('Action')
                ->width(100), // Fixed width for the action column
            Column::make('title')
                ->title('Title')
                ->width(250),

            Column::make('slug')
                ->title('Slug')
                ->width(200),

            Column::make('image')
                ->title('Cover Image')
                ->width(100),

            Column::make('status')
                ->title('Status')
                ->width(50),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Album_' . date('YmdHis');
    }
}
