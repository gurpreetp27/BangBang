@extends('layouts.main')
@section('content')


<section id="plan_info" class="wi-full py-5 text-center all-margin">
        <div class="container">
            <div class="title-main wi-full">
                <h2>{{ __('member.bet_title') }}</h2>
            </div>

            <div class="account-btn my-5 wi-full">
                    <h4>{{ __('member.bet_title_2') }}<br/>
                    {{ __('member.bet_title_2_2') }}</h4>
            </div>

            <div class="package-section wi-full">
                <ul>
                @foreach($plans as $k=>$p)
                <?php $counter = $k+1; ?>
                  <li>
                        <div class="package-sec">
                            <div class="package-header">
                                <h5 class="plan_name_{{$p->id}}">{{$p->name}}</h5>
                                <span class="price plan_price_{{$p->id}}"><small>€</small> {{floor($p->amount)}} <sup>
                                <?php $sub_val = explode('.',$p->amount);?>
                               .{{$sub_val[1]}}</sup></span>
                                <b></b>
                            </div>
                            <div class="package-body wi-full">
                                <ul>
                                    <?php echo $p->stats; ?>
                                    <!-- <li><p>Exclusive Members ONLY access</p></li>
                                    <li><p>E-mail notifications</p></li>
                                    <li><p>DAILY BANG predictions</p></li>
                                    <li><p>ACCA OF THE DAY predictions</p></li>
                                    <li><p>BOMBS OF THE DAY predictions</p></li> -->
                                </ul>
                            </div>
                            <div class="package-footer">
                                <a href="javascript:void('0')" onclick="selectPlan({{$p->id}});" class="package-btn">{{ __("member.plan_title_$counter") }}</a>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </section>


    <section id="account_info" class="wi-full py-5 text-center all-margin" style="display: none;">
        <div class="container">
        @if(!Auth::check())
        <form id="sign-up-form" class="sign-up-form" method="POST" action="{{ url('/member')}}">
        @else
        <form id="sign-up-form" class="sign-up-form" method="POST" action="{{ url('/')}}/member/{{Auth::user()->id}}">
        <input name="_method" type="hidden" value="PUT">
        @endif
        @csrf
          <input type="hidden" name="plan_id" class="plan_id" value="0">
            <div class="row">
                <div class="col-md-8">
                    <div class="account-section text-left">
                        <h5>{{ __('member.account_info') }}</h5>
                            <div class="form-row mt-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ __('member.name') }} *</label>
                                        <input type="text" name="name" readonly class="form-control" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ __('member.lastname') }} *</label>
                                        <input type="text" name="last_name" readonly class="form-control" value="{{$user->last_name}}">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>{{ __('member.email') }} *</label>
                                        <input type="email" name="email" readonly class="form-control" value="{{$user->email}}">
                                    </div>
                                </div>
                               <!--  <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ __('member.password') }} *</label>
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ __('member.re_password') }} *</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                    </div>
                                </div> -->
                            </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <aside>
                        <div class="account-section text-left">
                            <h5>{{ __('member.your_mem') }}</h5>
                                <div class="select-plan">
                                    <h5 class="plan_name">3-MONTHS</h5>
                                    <span class="price pay_info_plan"><small>€</small> 59 <sup>.90</sup></span>
                                </div>
                                <a href="javascript:void('0');" class="text-center my-2 chnge_mmbr change_membership">{{ __('member.change_mem') }}</a>

                                <div class="form-group payment_option mt-3">
                                    <label class="custm_radio">Paypal
                                      <input type="radio" name="payment_type" value="paypal" checked="checked">
                                      <span class="checkmark"></span>
                                    </label>
                                </div>
                               <div class="form-group paymeny_check">
                                    <label class="custm_checkbox">{{ __('member.i_agree') }} 
                                    <a href="{{url('/terms-conditions')}}" target="blank">{{ __('member.t_c') }}(*)</a>
                                      <input type="checkbox" id="tearm_condition" name="tearm_condition">
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="custm_checkbox">{{ __('member.i_agree') }}
                                    <a href="{{url('/privacy-policy')}}" target="blank">{{ __('member.p_p') }}(*)</a>
                                       <input type="checkbox" id="privacy-policy"  name="privacy-policy">
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="custm_checkbox">  <a href="{{url('/gdpr')}}" target="blank">{{ __('member.gdpr') }}(*)</a>
                                       <input type="checkbox" id="gdpr"  name="gdpr">
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="custm_checkbox">{{ __('member.newsletter') }}
                                       <input type="checkbox"  name="is_newsletter">
                                      <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary sign-up-form-button">{{ __('member.get_this_mem') }}</button>
                        </div>
                    </aside>
                </div>
            </div>
            </form>
        </div>
    </section>
    @endsection
    @section('js_file')
     <script src="{{asset('public/front/js/auth.js')}}"></script>
     <script src="{{asset('public/front/js/dashboard.js')}}"></script>
    @endsection