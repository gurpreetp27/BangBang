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
                                <div class="ibox-title">Edit Player</div>
                            </div>
                            <div class="ibox-body">
                                <form action="{{url('admin/addcontent/player/edit/save')}}" method="post">
                                 @csrf
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Player Name</label>
                                            <input class="form-control" type="text" placeholder="Player Name" value="{{$sport['name']}}" name="PlayerName">
                                        </div>
                                        <input type="hidden" name="aityd" value="{{$sport['id']}}">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

