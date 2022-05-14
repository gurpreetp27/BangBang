@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
 <link href="{{asset('public/adminn/assets/vendors/DataTables/datatables.min.css')}}" rel="stylesheet" />
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Review</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-body">
                                <form action="{{url('admin/review/edit/save')}}" method="post">
                                  @csrf
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                        <?php
                                          $explod = explode(' ', $data->name);

                                        ?>
                                       
                                            <label>First Name</label>
                                            <input type="hidden" name="reviewid" value="{{$data->id}}">
                                            <input class="form-control" type="text" placeholder="First Name" name="firstName" value="{{$explod[0]}}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" placeholder="First Name" name="lastName" value="{{$explod[1]}}" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control" rows="6" name="comment">{{$data->comment}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Star</label>
                                        <select class="form-control" name="star">
                                            <option value="1" @if($data->star==1) selected @endif>1</option>
                                            <option value="2" @if($data->star==2) selected @endif>2</option>
                                            <option value="3" @if($data->star==3) selected @endif>3</option>
                                            <option value="4" @if($data->star==4) selected @endif>4</option>
                                            <option value="5" @if($data->star==5) selected @endif>5</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                   </div>  
                  </div>
                </div>
                </div>
            </div>

            
@endsection

@push('script')


  @endpush