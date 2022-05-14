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
                                <div class="ibox-title">Send Custom Message</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/memberships/users/send/message')}}" method="post">
                                 @csrf 
                                  <div class="row">
                                        <div class="col-sm-10 form-group">
                                            <label>Message Send To:</label>
                                            <select class="form-control" name="member_type">
                                                <option value="1">ALL ACTIVE MEMBERS</option>
                                                <option value="2">ALL MEMBERS</option>
                                            </select>
                                         
                                        </div>
                                        
                                        <div class="col-sm-10 form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" name="message" rows="5"></textarea>
                                        </div>
                                    </div>
                                
                                    
                                    <div class="form-group">
                                     <a class="btn btn-default" href="{{Route('memberships')}}">Back</a>
                                        <button class="btn btn-primary align-center" type="submit">Send Message</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

