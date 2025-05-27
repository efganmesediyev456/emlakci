<?php

namespace App\DataTables;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ExamsDataTable extends DataTable
{
    protected $subcategory;

    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->$k = $v;
            }
            return $this;
        }
        
        $this->$key = $value;
        return $this;
    }
    
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($item) {
                return view('backend.pages.exams.actions', compact('item'), [
                    'editRoute' => route('admin.subcategories.exams.edit', [$this->subcategory->id, $item->id]),
                    'deleteRoute' => route('admin.subcategories.exams.destroy', [$this->subcategory->id, $item->id]),
                    'examQuestionRoute' => route('admin.subcategories.exams.questions.index',  ['subcategories'=>$this->subcategory->id, 'exam'=>$item->id]),
                ]);
            })
            ->addColumn('title', function ($item) {
                return $item->translate() ? $item->translate()->title : 'N/A';
            })
            ->addColumn('subtitle', function ($item) {
                return $item->translate() ? $item->translate()->subtitle : 'N/A';
            })
            ->addColumn('megasubtitle', function ($item) {
                return $item->translate() ? $item->translate()->megasubtitle : 'N/A';
            })
            ->editColumn('duration', function ($item) {
                return $item->duration ? $item->duration . ' dəq' : 'N/A';
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('d.m.Y H:i');
            })
            ->editColumn('type', function ($item) {
                return match($item->type){
                    1 => 'Əmək məcəlləsi',
                    2 => 'Təhsil qanunvericiliyi',
                };
                
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(Exam $model): QueryBuilder
    {
        return $model->newQuery()->where('subcategory_id', $this->subcategory->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('exams-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('title')->title('Başlıq'),
            Column::make('subtitle')->title('Alt Başlıq'),
            Column::make('megasubtitle')->title('Mega Alt Başlıq'),
            Column::make('duration')->title('Müddəti (dəq)'),
            Column::make('type')->title('Tip'),
            Column::computed('action')->title('Əməliyyatlar')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Exams_' . date('YmdHis');
    }
}