<?php

namespace App\DataTables;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
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
                return '
                        <a href="'.route('news.show', $row->id).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="'.route('news.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <form id="deleteForm-news-'.$row->id.'" action="'.route('news.destroy', $row->id).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="button" class="btn btn-danger btn-sm" onclick="handleDelete(\'deleteForm-news-'.$row->id.'\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';

            })
            ->editColumn('status', function ($row) {
                return '
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" data-id="'.$row->id.'" '.($row->status ? 'checked' : '').'>
                        <label class="form-check-label" for="statusLabel'.$row->id.'"></label>
                    </div>';
            })
            ->rawColumns(['action','image','status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(News $model): QueryBuilder
    {
        $news = $model->with('category')->newQuery();
        return $news;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('news-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('lfrtip')
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
            'title',
            'category.name',
            'image',
            'status',
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'News_' . date('YmdHis');
    }
}
