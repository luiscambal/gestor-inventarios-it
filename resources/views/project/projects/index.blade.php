@extends('layouts.master')

@section('content')
<style>
    .brd{
        border: #0b0b0b 1px solid;
    }
</style>
<section class="section">

    <h2 class="section-title">{{ __('Projects') }}</h2>

    @if($projects && $currantWorkspace)

    <div class="row mb-2">

        <div class="col-sm-4">
            @auth('web')
                @if($currantWorkspace->creater->id == Auth::user()->id)
                    <a class="btn btn-primary btn-rounded mb-3"  href="{{route('project.projects.create',$currantWorkspace->slug)}}">
                        <i class="mdi mdi-plus"></i> {{ __('Create Project') }}
                    </a>
                @endif
            @endauth
        </div>

        <div class="col-sm-8">
            <div class="text-sm-right status-filter">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-primary" data-status="All">{{ __('All')}}</button>
                </div>
                <div class="btn-group mb-3 ml-1">
                    <button type="button" class="btn btn-light" data-status="Ongoing">{{ __('Ongoing')}}</button>
                    <button type="button" class="btn btn-light" data-status="Finished">{{ __('Finished')}}</button>
                    <button type="button" class="btn btn-light" data-status="OnHold">{{ __('OnHold')}}</button>
                </div>

            </div>
        </div><!-- end col-->
    </div>

    <div class="row">
        @foreach ($projects as $project)

        <div class="col-12 col-sm-12 col-lg-6 animated filter {{$project->status}}">
            <div class="brd card author-box card-primary">
                <div class="brd card-body">
                    <div class="brd card-header-action">
                        <div class="brd dropdown card-widgets">
                            @auth('web')
                                <a href="#" class="brd btn active dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="dripicons-gear"></i></a>
                                <div class="brd dropdown-menu dropdown-menu-right">
                                @if($currantWorkspace->permission == 'Owner')
                                    <a class="dropdown-item" href="{{route('project.projects.edit',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-pencil mr-1"></i>{{ __('Edit')}}</a>
                                    <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('delete-form-{{$project->id}}').submit(): '');" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>{{ __('Delete')}}</a>
                                    <form id="delete-form-{{$project->id}}" action="{{ route('project.projects.destroy',[$currantWorkspace->slug,$project->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="brd dropdown-item" href="{{route('project.projects.invite.popup',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-email-outline mr-1"></i>{{ __('Invite')}}</a>
                                    <a class="brd dropdown-item" href="{{route('project.projects.share.popup',[$currantWorkspace->slug,$project->id])}}"><i class="mdi mdi-email-outline mr-1"></i>{{ __('Share')}}</a>
                                @else
                                    <a href="#" onclick="(confirm('Are you sure ?')?document.getElementById('leave-form-{{$project->id}}').submit(): '');" class="dropdown-item"><i class="mdi mdi-exit-to-app mr-1"></i>{{ __('Leave')}}</a>
                                    <form id="leave-form-{{$project->id}}" action="{{ route('project.projects.leave',[$currantWorkspace->slug,$project->id]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                                </div>
                            @endauth
                        </div>
                    </div>

                    <div class="brd author-box-name">

                        <a href="@auth('web'){{route('project.projects.show',[$currantWorkspace->slug,$project->id])}}@elseauth{{route('project.client.projects.show',[$currantWorkspace->slug,$project->id])}}@endauth" title="{{ $project->name }}" class="text-title">{{ $project->name }}</a>

                    </div>
                    <div class="brd author-box-job">
                        @if($project->status == 'Finished')
                            <div class="badge badge-success">{{ __('Finished')}}</div>
                        @elseif($project->status == 'Ongoing')
                            <div class="badge badge-secondary">{{ __('Ongoing')}}</div>
                        @else
                            <div class="badge badge-warning">{{ __('OnHold')}}</div>
                        @endif
                    </div>

                    <div class="brd author-box-description">
                        <p>
                            {{\Illuminate\Support\Str::limit($project->description, $limit = 100, $end = '...')}}
                        </p>
                    </div>
                    <p class="mb-1 brd">
                        <span class="pr-2 text-nowrap mb-2 d-inline-block">
                            <i class="mdi mdi-format-list-bulleted-type text-muted"></i>
                            <b>{{$project->countTask()}}</b> {{ __('Tasks')}}
                        </span>
                        <span class="text-nowrap mb-2 d-inline-block">
                            <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                            <b>{{$project->countTaskComments()}}</b> {{ __('Comments')}}
                        </span>
                    </p>

                    @foreach($project->users as $user)

                            <figure class="brd avatar mr-2 avatar-sm animated" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$user->name}}">
                                <img @if($user->avatar) src="{{asset('/storage/avatars/'.$user->avatar)}}" @else avatar="{{ $user->name }}"@endif class="rounded-circle">
                            </figure>

                    @endforeach

                    <div class="brd float-right mt-sm-0 mt-3">
                        <a href="@auth('web'){{route('project.projects.show',[$currantWorkspace->slug,$project->id])}}@elseauth{{route('project.client.projects.show',[$currantWorkspace->slug,$project->id])}}@endauth" class="btn btn-sm btn-primary">{{__('View More')}} <i class="dripicons-arrow-right"></i></a>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

    @else

        <div class="container mt-5">
            <div class="page-error">
                <div class="brd page-inner">
                    <h1>404</h1>
                    <div class="page-description">
                        {{ __('Page Not Found') }}
                    </div>
                    <div class="brd page-search">
                        <p class="brd text-muted mt-3">{{ __('It\'s looking like you may have taken a wrong turn. Don\'t worry... it happens to the best of us. Here\'s a little tip that might help you get back on track.')}}</p>
                        <div class="brd mt-3">
                            <a class="btn btn-info mt-3" href="{{route('home')}}"><i class="mdi mdi-reply"></i> {{ __('Return Home')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
</section>
<!-- container -->
@endsection

@push('style')
{{--    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('assets/css/vendor/bootstrap-tagsinput.css') }}" rel="stylesheet">
@endpush