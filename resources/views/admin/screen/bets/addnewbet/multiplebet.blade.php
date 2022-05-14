@extends('admin.layout.main')
@section('title','BangBang DashBoard')
@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
 <link href="{{asset('public/adminn/assets/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
<style type="text/css">
                .teamSelected,.playerSelected{
                  display: none;
                }
                .removenewform{
                  display: none;
                }
                #playerSelected span.select2.select2-container {
    width: 100%!important;
}
#teamSelected span.select2.select2-container {
    width: 100%!important;
}
.list-group-item{
  padding: 0 !important;
}
</style>
@endpush
@section('content')
            <div class="page-content fade-in-up">
            <form action="{{url('admin/bets/addmultiplesave')}}" method="post" id="form-id-tosub">
                @csrf
                <div class="row notclonable">
                    <div class="col-md-6 dfdfdf" id="cloneable">
                        <div class="ibox">
                              <div class="ibox-head">
                                  <div class="ibox-title">Add Multiple Bet- 1</div>
                                  <button class="btn btn-default btn-circle btn-md ml-auto mr-2  removenewform" type="button"><i class="fa fa-minus"></i></button>
                                  <button class="btn btn-default btn-circle btn-md  addnewform" type="button"><i class="fa fa-plus"></i></button>
                              </div>
                                 <div class="ibox-body">
                                   <div class="">
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Competition</label>
                                             <select class="form-control input-sm select2 com" name="competition[]">
                                             <option value="">Select Option</option>
                                             @if(count($data['competition']) > 0)
                                               @foreach($data['competition'] as $com)
                                                <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                @endforeach
                                             @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Sport</label>
                                            <select class="form-control input-sm select2 spo" name="sport[]">
                                                <option value="">Select Option</option>
                                                 @if(count($data['sport']) > 0)
                                                   @foreach($data['sport'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                    </div>
                                      <div class="row">
                                        <div class="col-sm-8 form-group">
                                            <label>Date and Time</label>
                                              <div class='input-group date'>
                                                  <input type='text' class="form-control datetimeclass" name="datetime[]" id="datet1" />
                                                  <span class="input-group-addon">
                                                      <span class="glyphicon glyphicon-calendar"></span>
                                                  </span>
                                              </div>
                                        </div>
                                      </div> 
                                      <hr> 
                                      <div class="col-12 m-b-20">
                                          <label>Whos is Playing</label>
                                          <div class="check-list">
                                          <div class="row">
                                           <input type="hidden" name="whostype" class="selectedwhoestype" value="">
                                            <div class="col-6">
                                                <label class="ui-radio ui-radio-success">
                                                <input type="radio" name="whosplaying" value="team">
                                                <span class="input-span"></span>Team</label>
                                            </div>
                                            <div class="col-6">
                                                <label class="ui-radio ui-radio-success">
                                                <input type="radio" name="whosplaying" value="individual">
                                                <span class="input-span"></span>Individual</label>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-sm-12 teamSelected">
                                        <div class="col-sm-6 form-group">
                                            <label>Team A</label>
                                             <select class="form-control input-sm select2 teama" name="teamA[]">
                                                <option value="">Select Option</option>
                                                 @if(count($data['team']) > 0)
                                                   @foreach($data['team'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Team B</label>
                                             <select class="form-control input-sm select2 teamb" name="teamB[]">
                                                <option value="">Select Option</option>
                                                 @if(count($data['team']) > 0)
                                                   @foreach($data['team'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                      </div>
                                      <div class="col-sm-12 playerSelected">
                                        <div class=" col-sm-6 form-group" >
                                            <label>Player A</label>
                                             <select class="form-control input-sm select2 playera" name="playerA[]">
                                                <option value="">Select Option</option>
                                                 @if(count($data['player']) > 0)
                                                   @foreach($data['player'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Player B</label>
                                             <select class="form-control input-sm select2 playerb" name="playerB[]">
                                                <option value="">Select Option</option>
                                                 @if(count($data['player']) > 0)
                                                   @foreach($data['player'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                            </select>
                                        </div>
                                       </div> 
                                    </div>
                                    <hr>
                                    <div class="row">
                                      <div class="col-sm-6 form-group" >
                                        <label>Tip Type</label>
                                         <select class="form-control select2 tip" name="tiptype[]">
                                             <option value="">Select Option</option>
                                                 @if(count($data['tiptype']) > 0)
                                                   @foreach($data['tiptype'] as $com)
                                                    <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                    @endforeach
                                                 @endif
                                        </select>
                                    </div>
                                     <div class="col-sm-6 form-group" >
                                        <label>Odds</label>
                                        <input class="form-control odds removechar" type="text" name="odds[]">
                                    </div>
                                    </div>
                                   <div class="row">
                                      <div class="col-sm-6 form-group" >
                                        <label>Actual Tip</label>
                                        <input class="form-control actip" type="text" placeholder="Actual Tip" name="actualtip[]">
                                      </div>
                                     <div class="col-sm-6 form-group btcatclass" >
                                     <input type="hidden" name="finalOdds" class="finalOdds" value="">
                                        <label>Bet Category</label>
                                         <select class="form-control betcat" name="betcategory" style="    height: 35px;">
                                             @if(count($data['betcategory']) > 0)
                                               @foreach($data['betcategory'] as $com)
                                                <option value="{{$com['id']}}" data-title="{{$com['name']}}">{{$com['name']}}</option> 
                                                @endforeach
                                             @endif
                                        </select>
                                    </div>
                                   </div> 
                                   <hr>

                                   <div class="row">
                                      <div class="col-sm-6 form-group ratingclass">
                                            <label>Trust Note</label>
                                             <select class="form-control rat" name="rating" style="height: 35px;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                    </div>
                                   <!--  <div class="col-sm-6 form-group" >
                                        <label>Comment</label>
                                          <input class="form-control" type="text" placeholder="(optional)">
                                    </div> -->
                                   </div>
                                  </div> 

                              <div class="form-group submit-btn">
                                  <button class="btn btn-primary" type="button" id="createPreview">Save</button>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>

            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Bit Preview</h4>
                  </div>
                  <div class="modal-body">
                  <h3 id="modalfinaloddssa">FinalOdds: </h3>
                   <div class="panel-group" id="accordion">
                      
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-succees" id="saveForm">Save</button>
                  </div>
                </div>
                
              </div>
          </div>
@endsection

@push('script')
<script type="text/javascript">

$('input[type=radio]').on('change', function(){
         var radioValue = $(this).closest('.ibox-body').find("input[type=radio]:checked").val();
            if(radioValue=='team'){
                $(this).closest('.ibox-body').find('.playerSelected').hide();
                $(this).closest('.ibox-body').find('.teamSelected').show();
                $(this).closest('.ibox-body').find('.selectedwhoestype').val('team');
            }else{
                $(this).closest('.ibox-body').find('.playerSelected').show();
                $(this).closest('.ibox-body').find('.teamSelected').hide();
                $(this).closest('.ibox-body').find('.selectedwhoestype').val('individual');
            }
  });
   
     /*$("input[name='whosplaying']").click(function(){
             //alert('df');
            
        });*/

     $('#createPreview').click(function(e){
      var html = '';
      var count = 1;
      var check='';
      var finalOdds=1; 
      $(".dfdfdf").each(function() {
             var timeStamp = "EST";
            //console.log($(this).find('.com').find(':selected').attr("data-title"));
             var com = $(this).find('.com').find(':selected').attr("data-title");
             var spo = $(this).find('.spo').find(':selected').attr("data-title");
             var datetime = $(this).find('.datetimeclass').val();
             var whostype = $(this).find('.selectedwhoestype').val();
             if(whostype=='team'){
             var teama = $(this).find('.teama').find(':selected').attr("data-title");
             var teamb = $(this).find('.teamb').find(':selected').attr("data-title");
             var playera = 'none';
             var playerb = 'none';
             }else{
             var playera = $(this).find('.playera').find(':selected').attr("data-title");
             var playerb = $(this).find('.playerb').find(':selected').attr("data-title");
             var teama = 'none';
             var teamb = 'none';
             }
             var tip = $(this).find('.tip').find(':selected').attr("data-title");
             var odds = $(this).find('.odds').val();
             var actip = $(this).find('.actip').val();
             var betcat = $('.betcat').find(':selected').attr("data-title");
             var rat = $('.rat').val();
             console.log(com);
             if(typeof com !=='undefined' && typeof spo!=='undefined' && typeof datetime!=='undefined' && typeof whostype!=='undefined' && typeof teama!=='undefined' && typeof teamb!=='undefined' && typeof playera!=='undefined' && typeof playerb!=='undefined' && typeof tip!=='undefined' && typeof odds!=='undefined' && typeof actip!=='undefined' && typeof betcat!=='undefined' && typeof rat!=='undefined'){
                   finalOdds=(finalOdds * odds);  
                   if(whostype=='team'){
                       html+='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse_'+count+'">Bet '+count+'</a></h4></div><div id="collapse_'+count+'" class="panel-collapse collapse"><div class="panel-body"><ul class="list-group list-group-full list-group-divider"><li class="list-group-item">Date Time:- '+datetime+' '+timeStamp+'</li><li class="list-group-item">Competition:- '+com+'</li><li class="list-group-item">Sport:- '+spo+'</li><li class="list-group-item">whosplaying:- '+whostype+'</li><li class="list-group-item">Team A:- '+teama+'</li><li class="list-group-item">Team B:- '+teamb+'</li><li class="list-group-item">Tip Type:- '+tip+'</li><li class="list-group-item">odds:- '+odds+'</li><li class="list-group-item">Actual Tip:- '+actip+'</li><li class="list-group-item">Bet Category:- '+betcat+'</li><li class="list-group-item">Rating:- '+rat+'</li></ul></div></div></div>'; 
                   }else{
                      html+='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse_'+count+'">Bet '+count+'</a></h4></div><div id="collapse_'+count+'" class="panel-collapse collapse"><div class="panel-body"><ul class="list-group list-group-full list-group-divider"><li class="list-group-item">Date Time:- '+datetime+'</li><li class="list-group-item">Competition:- '+com+'</li><li class="list-group-item">Sport:- '+spo+'</li><li class="list-group-item">whosplaying:- '+whostype+'</li><li class="list-group-item">Player A:- '+playera+'</li><li class="list-group-item">Player B:- '+playerb+'</li><li class="list-group-item">Tip Type:- '+tip+'</li><li class="list-group-item">odds:- '+odds+'</li><li class="list-group-item">Actual Tip:- '+actip+'</li><li class="list-group-item">Bet Category:- '+betcat+'</li><li class="list-group-item">Rating:- '+rat+'</li></ul></div></div></div>';

                   }
                  
             }else{
                check = 'failed'; 
                showMessage('All fields are Require, Please check  bet no:- '+count+'','danger');
             }
             //delete com; 
           count++;      
        });
       $('.finalOdds').val(finalOdds.toFixed(2));
       $('#modalfinaloddssa').text('FinalOdds-: '+finalOdds.toFixed(2));
        if(check!='failed'){
            $('#accordion').html('');
            $('#accordion').append(html);
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            })
        } 
      
     });

    var clonedNumner = 0;

     $('#saveForm').click(function(e){
          $("#form-id-tosub").submit();
     });
     var dfdfdfdf = 1;
     $('.addnewform').click(function(e){
       dfdfdfdf++;
       if($('.datetimeclass').val()!=''){
         $('.datetimeclass').data("DateTimePicker").destroy();
       }
       var clonedNum = clonedNumner + 2;
       var select = $(".select2").select2(); 
          select.select2('destroy'); 
          e.preventDefault();
          var cloned = $("#cloneable").clone(true); 
          cloned.find(".submit-btn").remove();
          cloned.find(".ibox-head").html('');
          cloned.find(".ibox-head").append('<div class="ibox-title">Add Multiple Bet- '+clonedNum+'</div>');
          cloned.find(".btcatclass").remove();
          cloned.find(".ratingclass").remove();
          cloned.find(".teamSelected").hide();
          cloned.find(".playerSelected").hide();
          cloned.find("input[name='whosplaying']").removeAttr('checked');
          cloned.insertAfter("#cloneable").find('input[type="radio"]').prop('name', 'whosplaying'+dfdfdfdf);
          $('.select2').select2();
          clonedNumner++;
          $('.removenewform').show();
     });
     
    
     $('.removenewform').click(function(e){
      $('.dfdfdf').not(':first').children().last().remove();
      clonedNumner--;
      if(clonedNumner === 0){
        $(this).hide();
      }
     });



</script>
  
   <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        
        
        <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
        
   <script src="{{asset('public/adminn/assets/vendors/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
          

      $('body').on('focus',".datetimeclass", function(){
         $(this).datetimepicker({
              format: "D MMM,YYYY - HH:mm"
            });
      });
     



        $(function () {
          $('.select2').select2();
       
         });
    
    $(".removechar").keyup(function() {
    var $this = $(this);
    $this.val($this.val().replace(/[^\d.]/g, ''));        
});
    </script>
@endpush