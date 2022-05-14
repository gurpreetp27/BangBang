@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
 <link href="{{asset('public/adminn/assets/vendors/summernote/dist/summernote.css')}}" rel="stylesheet" />
 <style>
   .btn-group.open ul.dropdown-menu {
    top: -11px!important;
}
.modal.fade.in{
  opacity: 1;
}
#myModal .modal-dialog {
    -webkit-transform: translate(0,-50%);
    -o-transform: translate(0,-50%);
    transform: translate(0,-50%);
    top: 50%;
    margin: 0 auto;
}
#myModal{
  background-color: rgba(0,0,0,0.6);
}
.rating2 span.active:after {
    content: "\2605";
    position: absolute;
    left: 0;
    color: #d82211;
}
.rating2 span {
    position: relative;
    font-size: 34px;
}
.rating2 span.active.half:after {
   width: 50%;
   overflow: hidden;
}
 </style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
                <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit template</div>
                    </div>
                    <div class="ibox">       
                            <div class="ibox-body">
                                <form action="{{url('admin/template/edit/save')}}" method="post">
                                  @csrf
                                    <input type="hidden" name="tid" value="{{$data['id']}}">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" placeholder="template Title" name="title" value="{{$data['title']}}" readonly>
                                    </div>

                                     <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" placeholder="Email template Subject" name="subject" value="{{$data['subject']}}">
                                    </div>

                                   <div class="form-group">
                                       <label>textarea <span style="font-size: 10px;font-weight: bold;">(*)use slug to print username or name in template like:- {username},{name}, {fname}, {lname}).</span></label>
                                        <textarea class="form-control" rows="10" id="summernote_air" name="content">{{$data['content']}}</textarea>
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

           
@endsection

@push('script')
<script src="{{asset('public/adminn/assets/vendors/summernote/dist/summernote.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
            $('#summernote_air').summernote({
               height: 200,
                toolbar: [
                  // [groupName, [list of button]]
                  ['style', ['bold', 'italic', 'underline']],
                  ['fontsize', ['fontsize']],
                  ['color', ['color']],
                ]
            });
        });
</script>
 
@endpush