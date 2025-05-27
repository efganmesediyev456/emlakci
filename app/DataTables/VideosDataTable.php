<?php

namespace App\DataTables;

use App\Models\Video;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VideosDataTable extends DataTable
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
                return view('backend.pages.videos.actions', compact('item'), [
                    'editRoute' => route('admin.subcategories.videos.edit', [$this->subcategory->id, $item->id]),
                    'deleteRoute' => route('admin.subcategories.videos.destroy', [$this->subcategory->id, $item->id]),
                ]);
            })
            ->addColumn('title', function ($item) {
                return $item->translate() ? $item->translate()->title : 'N/A';
            })
            ->editColumn('video_url', function ($item) {
                return $item->video_url ? '<a href="/storage/'.$item->video_url.'" target="_blank">Video Linki</a>' : 'N/A';
            })
            ->editColumn('thumbnail', function ($item) {
                if ($item->thumbnail) {
                    return '<img src="' . asset("storage/{$item->thumbnail}") . '" width="50">';
                }
                return 'N/A';
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('d.m.Y H:i');
            })
            ->rawColumns(['action', 'thumbnail', 'video_url'])
            ->setRowId('id');
    }

    public function query(Video $model): QueryBuilder
    {
        return $model->newQuery()->where('subcategory_id', $this->subcategory->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('videos-table')
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
            Column::make('video_url')->title('Video URL'),
            Column::make('thumbnail')->title('Örtük Şəkli'),
            Column::make('created_at')->title('Tarix'),
            Column::computed('action')->title('Əməliyyatlar')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Videos_' . date('YmdHis');
    }
}