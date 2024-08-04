<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use App\Models\Post;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\URL;

class PostDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('show', function ($model) {
                return link_to(route('post.show', $model->id), 'Show Post', ['class' => 'btn btn-sm btn-primary'], null, false);
            })
            ->addColumn('delete', function ($model) {
                return link_to(route('post.destroy', $model->id), 'Delete Post', ['class' => 'btn btn-sm btn-danger ms-2'], null, false);
            });
    }

    /**
     *  Get query source of dataTable.
     *
     * @param Post $model
     * @return QueryBuilder
     */
    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        \Log::info(['PARAMS' => $this->getBuilderParameters()]);
        \Log::info(__FILE__ . ' on line: ' . __LINE__);
        return $this->builder()
            ->setTableAttributes([
                'style' => 'width: 100%',
            ])
            ->pageLength(5)
            ->setTableId('post-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')

            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('title'),
            Column::make('body')->width(50),
            Column::make('created_at'),
            Column::computed('show'),
            Column::computed('delete')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Post_' . date('YmdHis');
    }
}
