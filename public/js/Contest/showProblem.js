function showProblem( id ){
    var route = "http://www.escoj.com/contest/gym/problem/" +id;
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