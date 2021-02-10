@extends('layouts.master')

@section('title') {{$title}} @endsection

@section('content')

@component('common-components.breadcrumb')
@slot('title') {{$title}} @endslot
@slot('li_1') جدید @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right">
                    <a  class="btn btn-primary mr-auto mb-3" href="{{URL::route('quizzes.index')}}">لیست {{$title}} ها</a>
                </div>
                <form action="{{URL::route('quizzes.store')}}{{isset($quiz) ? '?action=edit' : ''}}" method="post">
                    @csrf
                    @isset($quiz)
                        <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                    @endisset
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">نام {{$title}}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="q_name" value="{{$quiz->title ?? ''}}" required id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-md-2 col-form-label">زمان پاسخگویی</label>
                        <div class="col-md-4">
                            <input class="form-control" type="number" name="q_countdown"
                             placeholder="برحسب دقیقه"
                             value="{{$quiz->countdown ?? ''}}"
                             id="example-text-input">
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-form-label col-md-2">آزمون پایان درس یا دوره</label>
                        <select class="form-control col-md-4" name="public_type" id="public_type">
                            <option value="public" selected>پایان درس</option>
                            <option value="private">دوره</option>
                        </select>
                    </div> --}}

                    <h6>سوالات</h6>

                    <div class="questions-container">
                      @if (isset($quiz) && count($quiz->questions))
                      @foreach ($quiz->questions as $item)
                      <input type="hidden" name="q[1][id]" value="{{$item->id}}">
                          <div class="p-2 bg-light raduis-2">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">عنوان سوال</label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="q[1][title]" type="text" value="{{$item->title}}" id="example-text-input">
                                    </div>
                                </div>
                                <h4>پاسخ ها</h4>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="q[1][option_one]" value="{{$item->option_one}}" id="example-text-input">
                            
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                            value="option_one" {{$item->answer == 'option_one' ? 'checked' : ''}}>
                                        <label class="form-check-label" for="exampleRadios2">
                                            پاسخ درست
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="q[1][option_two]" value="{{$item->option_two}}" id="example-text-input">
                            
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                            value="option_two" {{$item->answer == 'option_two' ? 'checked' : ''}}> <label class="form-check-label" for="exampleRadios2">
                                            پاسخ درست
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="q[1][option_three]" value="{{$item->option_three}}" id="example-text-input">
                            
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                            value="option_three" {{$item->answer == 'option_three' ? 'checked' : ''}}> <label class="form-check-label" for="exampleRadios2">
                                            پاسخ درست
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="q[1][option_four]" value="{{$item->option_four}}" id="example-text-input">
                            
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                            value="option_four" {{$item->answer == 'option_four' ? 'checked' : ''}}> <label class="form-check-label" for="exampleRadios2">
                                            پاسخ درست
                                        </label>
                                    </div>
                                </div>
                            
                            </div>
                      @endforeach
                      @else 
                      <div class="p-2 bg-light raduis-2">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-2 col-form-label">عنوان سوال</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="q[1][title]" type="text" value="" id="example-text-input">
                                </div>
                            </div>
                            <h4>پاسخ ها</h4>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="q[1][option_one]" value="" id="example-text-input">
                        
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                        value="option_one">
                                    <label class="form-check-label" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="q[1][option_two]" value="" id="example-text-input">
                        
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                        value="option_two"> <label class="form-check-label" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="q[1][option_three]" value="" id="example-text-input">
                        
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                        value="option_three"> <label class="form-check-label" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="q[1][option_four]" value="" id="example-text-input">
                        
                                </div>
                                <div class="form-check col-md-2">
                                    <input class="form-check-input" type="radio" required name="q[1][answer]" id="exampleRadios2"
                                        value="option_four"> <label class="form-check-label" for="exampleRadios2">
                                        پاسخ درست
                                    </label>
                                </div>
                            </div>
                        
                        </div>   
                      @endif
                    </div>
                    <div class="mt-2">
                        <a href="#" class="add-question"><i class="mdi mdi-plus-thick"></i> جدید</a>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            @isset($quiz)
                            ویرایش
                            @else    
                            ثبت
                            @endisset

                        </button>
                    </div>

                </form>



            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection

@section('script')
<script>
    $('.add-question').click(function(e){
            e.preventDefault()
            let id = Date.now()
            $('.questions-container').append(`
            <div class="p-2 bg-light mt-2">
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-2 col-form-label">عنوان سوال</label>
                    <div class="col-md-10">
                        <input class="form-control" name="q[${id}][title]" type="text" value="" id="example-text-input">
                    </div>
                </div>
                <h4>پاسخ ها</h4>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="q[${id}][option_one]" value="" id="example-text-input">
            
                    </div>
                    <div class="form-check col-md-2">
                        <input class="form-check-input" type="radio" name="q[${id}][answer]" id="exampleRadios2" value="option_one">
                        <label class="form-check-label" for="exampleRadios2">
                            پاسخ درست
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="q[${id}][option_two]" value="" id="example-text-input">
            
                    </div>
                    <div class="form-check col-md-2">
                        <input class="form-check-input" type="radio" name="q[${id}][answer]" id="exampleRadios2" value="option_two">
                        <label class="form-check-label" for="exampleRadios2">
                            پاسخ درست
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="q[${id}][option_three]" value="" id="example-text-input">
            
                    </div>
                    <div class="form-check col-md-2">
                        <input class="form-check-input" type="radio" name="q[${id}][answer]" id="exampleRadios2" value="option_three">
                        <label class="form-check-label" for="exampleRadios2">
                            پاسخ درست
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input" class="col-md-1 col-form-label">گزینه </label>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="q[${id}][option_four]" value="" id="example-text-input">
            
                    </div>
                    <div class="form-check col-md-2">
                        <input class="form-check-input" type="radio" name="q[${id}][answer]" id="exampleRadios2" value="option_four">
                        <label class="form-check-label" for="exampleRadios2">
                            پاسخ درست
                        </label>
                    </div>
                </div>
            
            </div>
            `)
            
        })
</script>
@endsection