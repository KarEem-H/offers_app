<?php

namespace App\DataTables;

use App\Models\Offer;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class OfferDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        $dataTable->editColumn('offer_category_id', function($data) {
            return $data->category->title ?? '-';
        });

        $dataTable->editColumn('start_at', function($data) {
            return $data->start_at->format('Y-m-d');
        });

        $dataTable->editColumn('end_at', function($data) {
            return $data->end_at->format('Y-m-d');
        });

        $dataTable->editColumn('status', function($data) {
            return $data->status === 0 ? 'Expired' : 'Active';
        });

        return $dataTable->addColumn('action', 'offers.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Offer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Offer $model)
    {
        return $model->with('category')->newQuery();
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
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [ 'id',
            'title' => ['title' => 'Title', 'searchable' => true, 'orderable'=> false, 'name' => 'title' , 'data' => 'title_ar'],
            'slug' => ['title' => 'Slug', 'searchable' => true, 'orderable'=> false, 'name' => 'slug' , 'data' => 'slug_ar'],
            'price',
            'discount_price',
            'start_at' => ['title' => 'Start at', 'searchable' => false, 'orderable'=> true, 'name' => 'start_at'],
            'end_at' => ['title' => 'End at', 'searchable' => false, 'orderable'=> true, 'name' => 'end_at'],
            'status',
            'order',
            'offer_category_id',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'offers_datatable_' . time();
    }
}
