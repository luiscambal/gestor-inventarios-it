@extends('layouts.master')@section('content')    <div class="block block-rounded block-bordered">        <div class="block-header block-header-default">            <h3 class="block-title">Orden</h3>            <div class="block-options">                <button type="button" class="btn-block-option">                    <a href="{{ url('orden/create') }}" class="btn btn-hero-primary js-click-ripple-enabled"><i class="si si-plus"></i> Orden</a>                </button>            </div>        </div>        <div class="block-content">            <div class="table-responsive">                <table class="table table-bordered table-striped table-hover">                    <thead>                    <tr>                        <th>@lang('form.sno')</th><th>Orden de Compra</th><th>Fecha de Compra</th><th>Actions</th>                    </tr>                    </thead>                    <tbody>                    @php $x=0; @endphp                    @foreach($orden as $item)                        @php $x++;@endphp                        <tr>                            <td>{{ $x }}</td>                            <td><a href="{{ url('orden', $item->id) }}">{{ $item->ordenCompra }}</a></td>                            <td>{{ $item->fecha_compra }}</td>                            <td>                                <a href="{{ url('orden/' . $item->id . '/edit') }}">                                    <button type="submit" class="btn btn-sm btn-light m-1">@lang('form.update')</button>                                </a> /                                {!! Form::open([                                    'method'=>'DELETE',                                    'url' => ['orden', $item->id],                                    'style' => 'display:inline'                                ]) !!}                                {!! Form::button(__('form.deletee'), ['class' => 'btn btn-sm btn-light m-1','type' => 'submit']) !!}                                {!! Form::close() !!}                            </td>                        </tr>                    @endforeach                    </tbody>                </table>                <div class="pagination"> {!! $orden->render() !!} </div>            </div>        </div>    </div>@endsection