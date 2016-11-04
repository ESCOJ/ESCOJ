@extends('layouts.main')

@section('title' , 'Contests')

@section('styles')
    {!!Html::style('plugins/chosen/chosen.css')!!}
    {!!Html::style('plugins/flipclock/compiled/flipclock.css')!!}
    <style type="text/css">
        .nav-black {background: #333333; }
        .line {background: #333333; height: 1px; width: 100%;}
    </style>
@endsection

@section('content')
<div class="container">

     <div style="color:#337ab7;">
        <div class="col-lg-12" >
            <div>
                <br>
                    <h1 class="text-center" style="margin-top: -10px;"><strong>{{ $contest->name }}</strong></h1>
                    <div class="clock" id="clock" data-end-date= "{{ $contest->end_date }}" style="margin-left: 24em; margin-top: -1.3em;"></div>
                    <div class="message text-center"></div>
            </div>
        </div>
    </div>
</div>
    @include('contest.partials.show_contest.nav_tabs')

@endsection

@section('scripts')    
    {!!Html::script('plugins/chosen/chosen.jquery.js')!!}
    {!!Html::script('plugins/flipclock/compiled/flipclock.js')!!}
    {!!Html::script('js/Contest/showProblem.js')!!}

    
    <script type="text/javascript">  
        $('.select-chosen').chosen({
        });
    </script>

        <script type="text/javascript">
            var clock;
            
            $(document).ready(function() {
                // Set dates.
                //var futureDate  = new Date("2016","10","1","00","47","00");
                var futureDate  = new Date($("#clock").data('end-date'));

                var currentDate = new Date();

                // Calculate the difference in seconds between the future and current date
                var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

                // Calculate day difference and apply class to .clock for extra digit styling.
                function dayDiff(first, second) {
                    return (second-first)/(1000*60*60*24);
                }

                if (dayDiff(currentDate, futureDate) < 100) {
                    $('.clock').addClass('twoDayDigits');
                } else {
                    $('.clock').addClass('threeDayDigits');
                }

                if(diff < 0) {
                    diff = 0;
                }

                // Instantiate a coutdown FlipClock
                clock = $('.clock').FlipClock(diff, {
                    clockFace: 'DailyCounter',
                    countdown: true,
                    callbacks: {
                        stop: function() {
                            $('.message').html('The contest is over!')
                        }
                    }
                });
            });
        </script>
@endsection