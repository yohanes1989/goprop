@extends('admin.layouts.master')

@section('title', 'Main Banners')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.main_banner.index') }}"><i class="gi gi-picture"></i> Main Banners</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.main_banner.create', ['lang' => \Illuminate\Support\Facades\Lang::getLocale()]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Main Banner</a>
                </div>
            </div>

            <h4>Main Banners</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>EN</th>
                        <th>ID</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($main_banners as $idx=>$main_banner)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($main_banners->currentPage() - 1) * $main_banners->perPage()) }}</td>
                        <td>{{ $main_banner->title }}</td>
                        <td>{{ $main_banner->url }}</td>
                        <td>
                            @if($main_banner->hasTranslation('en'))
                                <a href="{{ route('admin.main_banner.edit', ['lang' => 'en', 'id' => $main_banner->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.main_banner.edit', ['lang' => 'en', 'id' => $main_banner->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($main_banner->hasTranslation('id'))
                                <a href="{{ route('admin.main_banner.edit', ['lang' => 'id', 'id' => $main_banner->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.main_banner.edit', ['lang' => 'id', 'id' => $main_banner->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                {!! Form::open(['route' => ['admin.main_banner.delete', 'id' => $main_banner->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $main_banners->render() !!}
    </div>
@endsection