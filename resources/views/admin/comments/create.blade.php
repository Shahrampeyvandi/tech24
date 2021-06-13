@extends('layouts.master')

@section('title') دیدگاه @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') دیدگاه @endslot
@slot('li_1') ویرایش @endslot
@endcomponent


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="text-right">
                    <a class="btn btn-primary mr-auto mb-3" href="{{URL::route('comments.index')}}">لیست دیدگاه
                        ها</a>
                </div>
                @component('common-components.admin-errors')
                @endcomponent
                <form action="{{URL::route('comments.update',['comment'=>$comment])}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="">دیدگاه: </label>
                            <textarea class="form-control" name="comment">{!! $comment->comment ?? '' !!}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 my-3 btn--wrapper">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            تایید دیدگاه
                        </button>

                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
