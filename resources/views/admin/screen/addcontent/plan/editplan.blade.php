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
                                <div class="ibox-title">Edit Plan</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/addcontent/plan/edit/save')}}" method="post">
                                 @csrf 
                                  <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Plan Name</label>
                                            <input class="form-control" type="text" placeholder="Plan Name" value="{{$sport['name']}}" name="planName">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Amount</label>
                                            <input class="form-control" type="text" placeholder="Amount" name="amount" value="{{$sport['amount']}}">
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Duration(Month)</label>
                                            <input class="form-control" type="text" placeholder="Duration" name="duration" value="{{$sport['duration']}}">
                                        </div>
                                    </div>
                                      <div class="col-sm-12 form-group">
                                          <label>Stats</label>
                                          <textarea class="form-control" rows="5" name="stats">{{$sport['stats']}}</textarea>
                                      </div>
                                    <input type="hidden" name="aityd" value="{{$sport['id']}}">
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

