@extends('layouts.main')
@section('content')

  <section class="wi-full py-5 text-center all-margin">
        <div class="container">
            <div class="title-main wi-full">
                <h2>{{__('member.VIEWRECURRENCY')}}</h2>
            </div>
            <div class="wi-full pt-5">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm result-table reviw-table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>{{__('member.plan')}}</th>
                                    <th>{{__('member.amount')}}</th>
                                    <th>{{__('member.payment_type')}}</th>
                                    <th>{{__('member.created_at')}}</th>
                                    <th>{{__('member.status')}}</th>
                                  </tr>
                                </thead>
                                <tbody>
                               
                                  <tr>
                                    <td>1</td>
                                    <td>{{$re_payment['get_plan']->name}}</td>
                                    <td>{{$re_payment['get_plan']->amount}}</td>
                                    <td>{{$re_payment->gateway}}</td>
                                    <td>{{$re_payment->created_at}}</td>
                                    <td>@if($re_payment->status == "Paid") Active @else InActive @endif</td>
                                    </tr>
                                  
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
    @endsection
    @section('js_file')
