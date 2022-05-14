@include('admin.layout.header')
@include('admin.layout.sidebar')
<style type="text/css">
  .alert{
   position: fixed;
   top: 70px;
   right: 10px;
   z-index: 1;
  }
</style>
<div class="content-wrapper">
        @if(Session::has('danger'))
           <div class="alert alert-danger alert-bordered">
               <strong>{{Session::get('danger')}}</strong>
            </div>
            @endif
             @if(Session::has('success'))
           <div class="alert alert-success alert-bordered">
               <strong>{{Session::get('success')}}</strong>
            </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
@yield('content')
@include('admin.layout.footer')
<script type="text/javascript">
	 $( document ).ready(function(){
            $('.alert').fadeIn('slow', function(){
               $('.alert').delay(5000).fadeOut(); 
            });
        });
</script>
