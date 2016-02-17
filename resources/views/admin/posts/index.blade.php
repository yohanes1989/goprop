@extends('admin.layouts.master')

@section('title', 'Posts')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.post.index') }}"><i class="fa fa-pencil"></i> Posts</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.post.create', ['lang' => \Illuminate\Support\Facades\Lang::getLocale()]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Post</a>
                </div>
            </div>

            <h4>Posts</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>EN</th>
                        <th>ID</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($posts as $idx=>$post)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($posts->currentPage() - 1) * $posts->perPage()) }}</td>
                        <td>{{ $post->title }} {!! $post->status==\GoProp\Models\Post::STATUS_PUBLISHED?'<span class="label label-success">Published</span>':'<span class="label label-default">Unpublished</span>' !!}</td>
                        <td>{{ implode(', ', $post->categories->lists('title')->all()) }}</td>
                        <td>
                            @if($post->hasTranslation('en'))
                                <a href="{{ route('admin.post.edit', ['lang' => 'en', 'id' => $post->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.post.edit', ['lang' => 'en', 'id' => $post->id, 'translate' => TRUE, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($post->hasTranslation('id'))
                                <a href="{{ route('admin.post.edit', ['lang' => 'id', 'id' => $post->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.post.edit', ['lang' => 'id', 'id' => $post->id, 'translate' => TRUE, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                {!! Form::open(['route' => ['admin.post.delete', 'id' => $post->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $posts->render() !!}
    </div>
@endsection