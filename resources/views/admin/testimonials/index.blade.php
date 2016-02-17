@extends('admin.layouts.master')

@section('title', 'Testimonials')

@section('breadcrumb_list')
    <li><a href="{{ URL::route('admin.testimonial.index') }}"><i class="fa fa-comment"></i> Testimonials</a></li>
@endsection

@section('content')
    <div class="block">
        <div class="block-title">
            <div class="block-options pull-right">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.testimonial.create', ['lang' => \Illuminate\Support\Facades\Lang::getLocale()]) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Testimonial</a>
                </div>
            </div>

            <h4>Testimonials</h4>
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
                    @foreach($testimonials as $idx=>$testimonial)
                    <tr>
                        <td class="text-center">{{ $idx + 1 + (($testimonials->currentPage() - 1) * $testimonials->perPage()) }}</td>
                        <td>{{ $testimonial->title }}</td>
                        <td>
                            @if($testimonial->hasTranslation('en'))
                                <a href="{{ route('admin.testimonial.edit', ['lang' => 'en', 'id' => $testimonial->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.testimonial.edit', ['lang' => 'en', 'id' => $testimonial->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($testimonial->hasTranslation('id'))
                                <a href="{{ route('admin.testimonial.edit', ['lang' => 'id', 'id' => $testimonial->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            @else
                                <a href="{{ route('admin.testimonial.edit', ['lang' => 'id', 'id' => $testimonial->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()]) }}" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Translate"><i class="fa fa-plus"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                {!! Form::open(['route' => ['admin.testimonial.delete', 'id' => $testimonial->id, 'backUrl' => \Illuminate\Support\Facades\Request::fullUrl()], 'style' => 'display: inline;']) !!}<button data-toggle="tooltip" title="" class="btn btn-default btn-xs btn-confirm" data-original-title="Delete"><i class="fa fa-times"></i></button>{!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {!! $testimonials->render() !!}
    </div>
@endsection