<?php

namespace App\DataTables;

use App\Models\ExamQuestion;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ExamQuestionsDataTable extends DataTable
{
    protected $subcategory;
    protected $exam;

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
            ->addColumn('action', function ($question) {
                return view('backend.pages.exam-questions.actions', compact('question'), [
                    'editRoute' => route('admin.subcategories.exams.questions.edit', 
                                    [$this->subcategory->id, $this->exam->id, $question->id]),
                    'deleteRoute' => route('admin.subcategories.exams.questions.destroy', 
                                     [$this->subcategory->id, $this->exam->id, $question->id]),
                   
                ]);
            })
            ->addColumn('question_text', function ($question) {
                return $question->translate() ? $question->translate()->question_text : 'N/A';
            })
            ->addColumn('options_count', function ($question) {
                return $question->options->count();
            })
            ->editColumn('type', function ($question) {
                return match($question->type){
                    1 =>'Qapalı',
                    2 => 'Açıq',
                    default => 'Naməlum',
                };
            })
            ->editColumn('created_at', function ($question) {
                return $question->created_at->format('d.m.Y H:i');
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    public function query(ExamQuestion $model): QueryBuilder
    {
        return $model->newQuery()->where('exam_id', $this->exam->id)->with('options');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('exam-questions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy( 0,'desc')
            ->selectStyleSingle()
            ->buttons([]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('question_text')->title('Sual'),
            Column::make('options_count')->title('Cavab variantları sayı'),
            Column::make('type')->title('Tipi'),
            // Column::make('points')->title('Xal'),
            // Column::make('position')->title('Sıra'),
            Column::computed('action')->title('Əməliyyatlar')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ExamQuestions_' . date('YmdHis');
    }
}