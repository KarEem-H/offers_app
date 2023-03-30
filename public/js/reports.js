$(document).ready(function(){

    $("#RiskForm").submit(function(e) {
        e.preventDefault();
        $form = $(this);

        $('.loader').removeClass('display_none');
        $('.submit').addClass('display_none');
        $('.questions').empty();

        $to= $($form).find('input[name ="to"]').val();
        $from= $($form).find('input[name ="from"]').val();
        $risk_id= $($form).find('select[name ="risk_id"]').val();
        $token= $($form).find('input[name ="_token"]').val();
        
        if(!$risk_id){
            $('.loader').addClass('display_none');
            $('.submit').removeClass('display_none');
            return;
        }

        $.ajax({
            type: 'post',
            url: $($form).attr('action'),
            data: {
                    risk_id: $risk_id,
                    to: $to,
                    from: $from,
                    _token: $token
            }

        }).done(function (result) {

            $('.loader').addClass('display_none');
            $('.submit').removeClass('display_none');

            if(result.answers_rate.length == 0){

                document.getElementById('pieChart').style.display = 'none'
                document.getElementById('no_data').style.display = 'block'

            }else{

                document.getElementById('pieChart').style.display = 'block'
                document.getElementById('no_data').style.display = 'none'

                loadPieChart(result);
                loadQuestionsCharts(result.questions, result)
            }
        
        
        }).fail(function (error) {
            console.log(error);
            $('.loader').addClass('display_none');
            $('.submit').removeClass('display_none');
        });
    });
 
    $("#risk").change(function() {
        $.ajax({
            url: $('[name=riskLeads]').val()+"?risk_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#lead').empty()
                $.each(data, function(key, lead){
                    const tag = `<option value="${lead.id}">${lead.email}</option>`
                    $('#lead').append(tag);
                });
            }
        });
    });

    $('#lead').on('change', function() {

        $lead_id = $("#lead").val();
        $risk_id = $("#risk").val();
        $token = $('input[name="_token"]').val();

        console.log($risk_id, $lead_id, $token)

        if ($risk_id && $lead_id && $token) {

            $.ajax({
                type: 'POST',
                url: $("#riskLeadReport").attr('action') ,
                dataType: 'json',
                data: {
                    lead_id :  $lead_id,
                    risk_id : $risk_id,
                    _token : $token
                }
                }).done(function(result) {
                    $('.loader').addClass('display_none');
                    $('.submit').removeClass('display_none');
        
                    if(result.answers_rate.length == 0){
        
                        document.getElementById('pieChart').style.display = 'none'
                        document.getElementById('no_data').style.display = 'block'
                        $('#lead').addClass('display_none');

                    }else{
        
                        document.getElementById('pieChart').style.display = 'block'
                        document.getElementById('no_data').style.display = 'none'
                        viewLeadData(result.lead);
                        loadPieChart(result);
                        loadQuestionsCharts(result.questions, result)
                    }
                }).fail(function(error) {
                    console.log(error);
                    $('.loader').addClass('display_none');
                    $('.submit').removeClass('display_none');
                });
        }
    });

    function loadPieChart(result) {

        $('#pieChart').remove();
        $('.pie-chart-container').append($('<canvas/>',{'id':'pieChart'}));
        var ctx = document.getElementById('pieChart').getContext('2d');
        console.log(result);
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [`risk`, `safe` ],
                datasets: [{
                    label: 'Chart',
                    data: [result.risk_avg, result.safe_avg],
                    backgroundColor: [
                        '#ff6384',
                        '#22a7f0'
                    ],
                    borderColor: [
                        '#ff6384',
                        '#22a7f0'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                tooltips: {
                    enabled: true
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            console.log(value, ctx);
                            
                            return value + '%';
                        },
                        color: '#fff',
                    }
                }
            }

        })
    }

    function loadQuestionsCharts(questions, result){
        $('.questions').empty();
        const options = {
                tooltips: {
                    enabled: true
                },
                plugins: {
                    datalabels: {
                        color: '#fff',
                    },
                },
                legend:{
                    position:'right'
                }
        };

        $.each(questions, function(key, object){

            var parentDiv = $('.chart').clone();
            var ctx = $(parentDiv).find('canvas');

            if(object.questionObj.type == 'toggle'){
                
                ctx.attr('id', object.questionObj.id)
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: [ "Off",  "On"],
                        datasets: [{
                            label: 'Chart',
                            data: [object.answers[0] || 0, object.answers[100]||1],
                            backgroundColor: [
                                '#ff6384',
                                '#22a7f0'
                            ],
                            borderColor: [
                                '#ff6384',
                                '#22a7f0'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: options
                });
            }else if(object.questionObj.type == 'rate' || object.questionObj.type == 'amount'){
                const colors = Object.keys(object.answers).map(x=> getRandomColorHex());
                console.log();
                ctx.attr('id', object.questionObj.id)
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(object.answers).map(label => label + "%"),
                        datasets: [{
                            barPercentage: 1,
                            label: 'Chart',
                            data: Object.values(object.answers),
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        tooltips: {
                            enabled: true
                        },
                        indexAxis: 'x',
                        plugins: {
                                datalabels: {
                                    color: '#fff',
                                },
                            },
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    beginAtZero: true,
                                    steps: 1,
                                    stepSize: object.questionObj.type == 'amount' ? 
                                        (Math.max(... Object.values(object.answers)) < 5 ? 1 : null)
                                    : 1,
                                    // max: ,
                                    // min: 
                                }
                            }]
                        }
                    }


                });
            
            }else{
                console.log(result)
                ctx = plotQuestionRate(object, ctx, result.questions_risk[object.questionObj.id])

            }

            $(parentDiv).find('h2').text(object.questionObj.name.ar + "؟");
            $(parentDiv).find('h2').append("<small style='margin:0px 2px 0px'>("+ object.questionObj.type +")</small>");
        
            $(".questions").append($(parentDiv).removeClass('display_none chart'));

        });

    }

    function getRandomColorHex() {
            var hex = "0123456789ABCDEF",
                color = "#";
            for (var i = 1; i <= 6; i++) {
            color += hex[Math.floor(Math.random() * 16)];
            }
            return color;
    }

    function plotQuestionRate(object, ctx, risk_value){
        
        const colors = object.questionObj.answers.map(x=> getRandomColorHex());
        ctx.attr('id', object.questionObj.id)
        
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [`risk`, `safe`],
                datasets: [{
                    label: 'Chart',
                    data: [ 
                        risk_value,
                        100-risk_value
                     ],
                    backgroundColor: [
                        '#ff6384',
                        '#22a7f0'
                    ],
                    borderColor: [
                        '#ff6384',
                        '#22a7f0'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                tooltips: {
                    enabled: true
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            return value + '%';
                        },
                        color: '#fff',
                    },
                },
                legend:{
                    position:'right'
                }
            }
        });

        return ctx;
    }       
    
    function viewLeadData(lead) {
        $('#leadInfo').find('.name').html(lead.name);
        $('#leadInfo').find('.phone').html(lead.phone);
        $('#leadInfo').find('.email').html(lead.email);
        $('#leadInfo').removeClass('display_none');
    }
})
