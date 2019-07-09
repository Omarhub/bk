<?php

namespace Webkul\Admin\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;

/**
 * CustomerDataGrid class
 *
 * @author Prashant Singh <prashant.singh852@webkul.com> @prashant-webkul
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class CustomerDataGrid extends DataGrid
{
    protected $index = 'customer_id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('customers')
                ->leftJoin('customer_groups', 'customers.customer_group_id', '=', 'customer_groups.id')
                ->addSelect('customers.id as customer_id', 'customers.email', 'customer_groups.name', 'status')
                ->addSelect(DB::raw('CONCAT(customers.first_name, " ", customers.last_name) as full_name'));

        $this->addFilter('customer_id', 'customers.id');
        $this->addFilter('full_name', DB::raw('CONCAT(customers.first_name, " ", customers.last_name)'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'customer_id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'full_name',
            'label' => trans('admin::app.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'email',
            'label' => trans('admin::app.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.datagrid.group'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.datagrid.status'),
            'type' => 'boolean',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'wrapper' => function ($row) {
                if ($row->status == 1) {
                    return 'Activated';
                } else {
                    return 'Blocked';
                }
            }
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Edit',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.customer.edit',
            'icon' => 'icon pencil-lg-icon',
            'title' => trans('admin::app.customers.customers.edit-help-title')
        ]);

        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'admin.customer.delete',
            'icon' => 'icon trash-icon',
            'title' => trans('admin::app.customers.customers.delete-help-title')
        ]);

        $this->addAction([
            'type' => 'Add Note',
            'method' => 'GET',
            'route' => 'admin.customer.note.create',
            'icon' => 'icon note-icon',
            'title' => trans('admin::app.customers.note.help-title')
        ]);
    }

    /**
     * Customer Mass Action To Delete And Change Their
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type' => 'delete',
            'label' => 'Delete',
            'action' => route('admin.customer.mass-delete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type' => 'update',
            'label' => 'Update Status',
            'action' => route('admin.customer.mass-update'),
            'method' => 'PUT',
            'options' => [
                'Active' => 1,
                'Inactive' => 0
            ]
        ]);

        $this->enableMassAction = true;
    }
}