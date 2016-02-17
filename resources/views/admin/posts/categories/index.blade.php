@extends('admin.layouts.master')

@section('title', 'Categories')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.post.index') }}"><i class="fa fa-pencil"></i> Posts</a></li>
    <li><a href="{{ URL::route('admin.post.category.index') }}">Categories</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.post.category.create', ['lang' => \Illuminate\Support\Facades\Lang::getLocale()]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</a>
                </div>
            </div>

            <h4>Categories</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>EN</th>
                        <th>ID</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $idx=>$category)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($categories->currentPage() - 1) * $categories->perPage()) }}</td>
                        <td>{{ $category->title }} ({{ $category->postsCount }})</td>
                        <td>
                            @if($category->hasTranslation('en'))
                                <a href="{{ route('admin.post.category.edit', ['lang' => 'en', 'id' => $category->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.post.category.edit', ['lang' => 'en', 'id' => $category->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($category->hasTranslation('id'))
                                <a href="{{ route('admin.post.category.edit', ['lang' => 'id', 'id' => $category->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.post.category.edit', ['lang' => 'id', 'id' => $category->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                {!! Form::open(['route' => ['admin.post.category.delete', 'id' => $category->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $categories->render() !!}
    </div>
@endsection