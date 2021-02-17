@extends('layouts.dashboard')

@section('sub_menu')
    <li class="breadcrumb-item active"> <i class="fa fa-book"></i> @lang('general.' . getModel()) </li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @php $options = ['create', 'print', 'import', 'export']; @endphp
            @include('dashboard.includes.card._header')
            <div class="card-body">
                @include('dashboard.includes.card._body')
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th class="remove-when-print"> <input type="checkbox" id="check-all"> </th>
                                <th> @lang('subjects.subject') </th>
                                <th> @lang(getModel() . '.question') </th>
                                <th> @lang(getModel() . '.answers') </th>
                                <th> @lang(getModel() . '.correct') </th>
                                <th> @lang(getModel() . '.degree') </th>
                                <th> @lang(getModel() . '.attach') </th>
                                <th class="remove-when-print"> @lang('general.action') </th>
                            </tr>
                        </thead>
                        <tbody id="load_data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--
    <div class="col-md-4">
        <div style="position: fixed; width: 25%">
            {{-- Form Create Blade --}}
            {{-- @include('dashboard.includes.form._create')
        </div>
    </div>
    --}}
</div>
@endsection
