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
                if (auth()->user()->can('delete_posts')) {
                   return link_to(route('post.destroy', $model->id), 'Delete Post', ['class' => 'btn btn-sm btn-danger ms-2'], null, false);
                }
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('Y-m-d H:i:s');
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
        return $this->builder()
            ->setTableAttributes([
                'style' => 'width: 100%',
            ])
            ->parameters([
                'columnDefs' => [
                    ['targets' => [0], 'width' => '5%'],
                    ['targets' => [1], 'width' => '15%'],
                    ['targets' => [2], 'width' => '50%'],
                    ['targets' => [3], 'width' => '10%'],
                    ['targets' => [4], 'width' => '10%'],
                    ['targets' => [5], 'width' => '10%'],
                ],
            ])
//            ->columnDefs()
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
        $columns = [
            Column::make('id'),
            Column::make('title'),
            Column::make('body'),
            Column::make('created_at'),
            Column::computed('show')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];

        if (auth()->user()->can('delete_posts')) {
            $columns[] = Column::computed('delete');
        }

        return $columns;
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
