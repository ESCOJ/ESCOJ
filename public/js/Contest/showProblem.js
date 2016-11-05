function showProblem( problem_id , contest_id){
    var route = "http://www.escoj.com/contest/gym/problem/" +problem_id+"/"+ contest_id;
    $.ajax({
        url: route,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            $("#problem").html(data);
            $("#problem").fadeIn();
            $('#problem_table').fadeOut();
        }
    });
};

function showProblemsTable(){
    $("#problem").fadeOut();
    $("#problem_table").fadeIn();
}

function showJudgments( id ){
    var route = "http://www.escoj.com/contest/gym/judgments/" +id;
    $.ajax({
        url: route,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            $("#judgments_table").html(data);
        }
    });
};
function addJudgment( problem_id ){
    $("#div_problem_id").attr("tabindex",-1).focus();
    $("#problem_id").val(problem_id);
    $('#code').fileinput('clear');
    clearBox();
    $(".select-chosen").chosen({ width: "100%" });
    $(".select-chosen").trigger("chosen:updated");
    $('.nav-tabs a[href="#submit"]').tab('show');
};

$(function(){
    $("#formuploadajax").on("submit", function(e){
        e.preventDefault();
        $("#your_code_in_the_editor").val(editor.getValue())
        var f = $(this);
        var formData = new FormData(document.getElementById("formuploadajax"));
        //formData.append("dato", "valor");
        //formData.append(f.attr("name"), $(this)[0].files[0]);
        var route = "http://www.escoj.com/judgment";

        $.ajax({
            url: route,
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,

            success: function(msj){

                clearErrors();

                var msj_success = 
                    '<div id = "msj-success" class="alert alert-success alert-dismissible" role="alert" >'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close" >'+
                            '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                        '<p><strong><center>' + msj.message  + '</center></strong</p>'+
                    '</div>';

                $('#code').fileinput('clear');
                clearBox();

                $("#div_success").append(msj_success);
                $("#div_success").fadeIn();


                setTimeout(function () {
                    $('div.alert').delay(3000).fadeOut(350);
                    showJudgments( $('#contest_id').val() );
                    $('.nav-tabs a[href="#judgments"]').tab('show');
                }, 3200);
            },

            error:function(msj){

                clearErrors();

                $.each( msj.responseJSON, function(key,value) {
                    $("#span_"+key).html('<strong>'+value+'</strong>');
                    $("#div_"+key).addClass('has-error');
                    $("#span_"+key).fadeIn();
                });
            }

        });

    });
});

function clearBox(){
    var editor = ace.edit("editor");
    editor.setValue("");
};

function clearErrors(){
    $("#div_success").html('');

    $("#span_problem_id, #span_language, #span_code, #span_your_code_in_the_editor").html('');

    $("#span_problem_id, #span_language, #span_code, #span_your_code_in_the_editor").fadeOut();

    $("#div_problem_id, #div_language, #div_code, #div_your_code_in_the_editor").removeClass('has-error');
};

$(document).on('click','.pagination a',function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var user = $("#user").val();
    var problem = $("#problemm").val();
    var language = $("#language").val();
    var filter_or_paginate = true;
    var route = "http://www.escoj.com/contest/gym/judgments/" +$("#contest_id").val();
    $.ajax({
        url: route,
        data: {page: page, user: user, problem: problem, language: language, filter_or_paginate: filter_or_paginate},
        type: 'GET',
        dataType: 'json',
        success: function(data){
            $(".judgments").html(data);
        }
    });
});


function showJudgmentsFiltered(){

    var user = $("#user").val();
    var problem = $("#problemm").val();
    var language = $("#language").val();
    var filter_or_paginate = true;
    var route = "http://www.escoj.com/contest/gym/judgments/"+$("#contest_id").val();

    $.ajax({
        url: route,
        data: {user: user, problem: problem, language: language, filter_or_paginate: filter_or_paginate},
        type: "GET",
        dataType: "json",
        success: function(data){
            $(".judgments").html(data);
        }

    });

};


function showScoreBoard( id ){
    var route = "http://www.escoj.com/contest/gym/scoreboard/" +id;
    $.ajax({
        url: route,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            $("#scoreboard_table").html(data);
        }
    });
};