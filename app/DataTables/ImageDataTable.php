<?php

namespace App\DataTables;

use App\Models\AlbumImage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ImageDataTable extends DataTable
{


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
            <form id="deleteForm-albumImage-'.$row->id.'" action="'.route('album-image.destroy', $row->id).'" method="POST" style="display:inline;">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete(\'deleteForm-albumImage-'.$row->id.'\')">
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
    public function query(AlbumImage $model)
    {
        $album_id = request()->route('album') | 0 ;
        return $model::with('album')->where('album_id', $album_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('image-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('frt<"mt-3 d-inline-flex justify-content-between align-items-center w-100" lip>')
                    ->orderBy(1)
                    ->lengthMenu([[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]]);
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
            Column::make('caption')
                ->title('Caption')
                ->width(250),

            Column::make('cover_image')
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
        return 'Image_' . date('YmdHis');
    }
}
