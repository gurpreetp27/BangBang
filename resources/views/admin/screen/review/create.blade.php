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
                <div class="col-sm-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Add Review</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-body">
                                <form action="{{url('admin/review/add')}}" method="post">
                                  @csrf
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                        <label>First Name</label>
                                            <input class="form-control" type="text" placeholder="First Name" name="firstName" value="{{old('firstname')}}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" placeholder="First Name" name="lastName" value="{{old('lastName')}}" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control" rows="6" name="comment">{{old('comment')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Star</label>
                                        <select class="form-control" name="star">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit">Submit</button>
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