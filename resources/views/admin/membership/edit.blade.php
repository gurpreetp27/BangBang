@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')

@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Edit User Info</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/memberships/users/edit/'.$user['id'])}}" method="post">
                                 @csrf 
                                  <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" placeholder="Plan Name" value="{{$user['name']}}" name="name">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" placeholder="Last Name" name="last_name" value="{{$user['last_name']}}">
                                        </div>
                                         <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" placeholder="Amount" name="email" readonly value="{{$user['email']}}">
                                        </div>
                                      
                                        <div class="col-sm-6 form-group">
                                            <label>Membership Expiry date</label>
                                            <input class="form-control" readonly type="text" placeholder="Duration" name="duration" value="{{$user['getMembership']['end_date']}}">
                                        </div>
                                    </div>
                                
                                    
                                    <div class="form-group">
                                     <a class="btn btn-default" href="{{Route('memberships')}}">Back</a>
                                        <button class="btn btn-primary align-center" type="submit">Update</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

