@extends('admin.layouts.master')

@section('title', 'Pages')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.page.index') }}"><i class="fa fa-file-o"></i> Pages</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.page.create', ['lang' => \Illuminate\Support\Facades\Lang::getLocale()]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Page</a>
                </div>
            </div>

            <h4>Pages</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Identifier</th>
                        <th>Title</th>
                        <th>EN</th>
                        <th>ID</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pages as $idx=>$page)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($pages->currentPage() - 1) * $pages->perPage()) }}</td>
                        <td>{{ $page->identifier }}</td>
                        <td>{{ $page->title }}</td>
                        <td>
                            @if($page->hasTranslation('en'))
                                <a href="{{ route('admin.page.edit', ['lang' => 'en', 'id' => $page->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.page.edit', ['lang' => 'en', 'id' => $page->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($page->hasTranslation('id'))
                                <a href="{{ route('admin.page.edit', ['lang' => 'id', 'id' => $page->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.page.edit', ['lang' => 'id', 'id' => $page->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                {!! Form::open(['route' => ['admin.page.delete', 'id' => $page->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $pages->render() !!}
    </div>
@endsection