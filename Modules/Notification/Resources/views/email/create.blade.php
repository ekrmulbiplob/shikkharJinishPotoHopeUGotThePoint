@extends('layouts.modal', ['size' => 'md'])

@section('modal')
    <div class="form-body">
        <div class="row">

            <div class="col-md-12 col-sm-12">
                <label class="col-form-label label-align" for="departments">
                    {{trans('app.department')}}
                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="left"
                       title="{{ trans('help.click_to_select_department')}}"></i>
                </label>
                <div class="item form-group">
                    <select class="form-control" name="department" id="departments">
                        <option value="">{{trans('app.all')}}</option>
                        @foreach(get_departments() as $key => $item)
                            <option value="{{$key}}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <label class="col-form-label label-align" for="employee_id">
                    {{trans('app.employees')}}  (left empty iff you want to send all)
                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="left"
                       title="{{ trans('help.left_empty_if_all')}}"></i>
                </label>
                <div class="item form-group">
                    <select multiple class="form-control select2-ajax" data-text="{{trans('help.search_employee')}}"
                            data-link="{{route('employee.getEmployee')}}" name="employees[]" id="employee-filter">
                        <option value="">{{trans('app.select_employee')}}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <label class="col-form-label label-align" for="subject">
                    {{trans('app.subject')}}
                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="left" title="{{ trans('help.subject')}}"></i>
                </label>
                <div class="item form-group">
                    <input class="form-control" name="subject" id="subject" placeholder="insert subject here">
                </div>
            </div>

            <div class="col-md-12 col-sm-12">
                <label class="col-form-label label-align" for="body">
                    {{trans('app.body')}} <span class="required">*</span>
                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="left"
                       title="{{ trans('help.body')}}"></i>
                </label>
                <div class="item form-group">
                    <textarea class="form-control"  id="body" name="body" required></textarea>
                </div>
            </div>

        </div>
    </div>

@endsection

{{--@include('notification::scripts.formScript')--}}
