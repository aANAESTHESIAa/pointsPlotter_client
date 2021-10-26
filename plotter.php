<!doctype html>
<html lang="RU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Отчисовка точек</title>

    <!-- Scripts -->
<!--    <script src="app.js"></script>-->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light myheader shadow-sm">
        <div class="container">
            <a class="navbar-brand" style="color: #377169" href="/">
                PointsPlotter
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link">О нас <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link">Обратная связь <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" >FAQ <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link">Обучение <span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a class="nav-link" style="color: #377169" >Button</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    // Read JSON file
    $firstdatasetjson = file_get_contents('./data/classone.json');
    $zerodatasetjson = file_get_contents('./data/classzero.json');
    $seconddatasetjson = file_get_contents('./data/classtwo.json');
    $linedatasetjson = file_get_contents('./data/linepoints.json');
    ?>
    <div class="container mt-5">

<!--        @include('inc.messages')-->
        <div class="row">
            <canvas id="myChart" width="400" height="400"></canvas>
            <script type="text/javascript">

                //defining datasets
                let FIRSTDATASET = '<?php echo $firstdatasetjson;?>';
                let FIRSTCLASSPOINTS = JSON.parse(FIRSTDATASET);

                let ZERODATASET = '<?php echo $zerodatasetjson;?>';
                let ZEROCLASSPOINTS = JSON.parse(ZERODATASET);

                let SECONDDATASET = '<?php echo $seconddatasetjson;?>';
                let SECONDLASSPOINTS = JSON.parse(SECONDDATASET);

                let LINEDATASET = '<?php echo $linedatasetjson;?>';
                let LINEPOINTS = JSON.parse(LINEDATASET);

                //defining photo_id for dataset
                let zeroClassPhotoIDs = ZEROCLASSPOINTS.map(function (elem) {
                    return elem.photo_id;
                })
                let firstClassPhotoIDs = FIRSTCLASSPOINTS.map(function (elem) {
                    return elem.photo_id;
                })
                let secondClassPhotoIDs = SECONDLASSPOINTS.map(function (elem) {
                    return elem.photo_id;
                })

                //defining anomaly_id for datasets
                let zeroClassAnomalyIDs = ZEROCLASSPOINTS.map(function (elem) {
                    return elem.anomaly_id;
                })
                let firstClassAnomalyIDs = FIRSTCLASSPOINTS.map(function (elem) {
                    return elem.anomaly_id;
                })
                let secondClassAnomalyIDs = SECONDLASSPOINTS.map(function (elem) {
                    return elem.anomaly_id;
                })

                const ctx = document.getElementById('myChart').getContext('2d');

                const options = {
                    responsive: true, // Instruct chart js to respond nicely.
                    maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
                    tooltips : {
                        displayColors: false,

                        callbacks : { // HERE YOU CUSTOMIZE THE LABELS
                            title : function() {
                                return ;
                            },
                            label : function(tooltipItem, data) {
                                let dataset = tooltipItem.datasetIndex
                                console.log(tooltipItem.datasetIndex)
                                if (dataset === 0){
                                    console.log(zeroClassPhotoIDs[tooltipItem.index])
                                    return "anomaly_id :" + zeroClassAnomalyIDs[tooltipItem.index]
                                }
                                if (dataset === 1){
                                    console.log(firstClassPhotoIDs[tooltipItem.index]);
                                    return "anomaly_id :" + firstClassAnomalyIDs[tooltipItem.index]
                                }
                                if (dataset === 2){
                                    console.log(secondClassPhotoIDs[tooltipItem.index]);
                                    return "anomaly_id :" + secondClassAnomalyIDs[tooltipItem.index]
                                }
                            },
                            beforeLabel : function(tooltipItem, data) {
                                let dataset = tooltipItem.datasetIndex
                                console.log(tooltipItem.datasetIndex)
                                if (dataset === 0){
                                    console.log(zeroClassPhotoIDs[tooltipItem.index])
                                    return "photo_id :" + zeroClassPhotoIDs[tooltipItem.index]
                                }
                                if (dataset === 1){
                                    console.log(firstClassPhotoIDs[tooltipItem.index])
                                    return "photo_id :" + firstClassPhotoIDs[tooltipItem.index]
                                }
                                if (dataset === 2){
                                    console.log(secondClassPhotoIDs[tooltipItem.index])
                                    return "photo_id :" + secondClassPhotoIDs[tooltipItem.index]
                                }
                            },
                        }
                    },
                };

                let myChart = new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: 'classZero', // Name the series
                            showLine: false,
                            data: ZEROCLASSPOINTS, // Specify the data values array
                            borderColor: '#FF0000', // Add custom color border
                            backgroundColor: '#FF0000', // Add custom color background (Points and Fill)
                        },
                            {
                            label: 'classOne', // Name the series
                            showLine: false,
                            data: FIRSTCLASSPOINTS, // Specify the data values array
                            borderColor: '#2196f3', // Add custom color border
                            backgroundColor: '#2196d3', // Add custom color background (Points and Fill)
                            },

                            {
                                label: 'extra points', // Name the series
                                showLine: false,
                                data: SECONDLASSPOINTS, // Specify the data values array
                                borderColor: '#00FF00', // Add custom color border
                                backgroundColor: '#00FF00', // Add custom color background (Points and Fill)
                            },
                            {
                                type: 'line',
                                label: 'Separating hyperplane', // Name the series
                                showLine: true,
                                fill: false,
                                data: LINEPOINTS, // Specify the data values array
                                borderColor: '#990099', // Add custom color border
                                backgroundColor: '#990099', // Add custom color background (Points and Fill)
                                pointRadius: 1,
                            }
                        ]
                    },
                    options: options
                });

            </script>
        </div>
    </div>
</div>
<footer class="container mt-5">
    <p class="float-right"><a href="#" class="go_to_top" > <svg class="bi bi-arrow-up-square" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path fill-rule="evenodd" d="M4.646 8.354a.5.5 0 0 0 .708 0L8 5.707l2.646 2.647a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 0 0 0 .708z"/>
                <path fill-rule="evenodd" d="M8 11.5a.5.5 0 0 0 .5-.5V6a.5.5 0 0 0-1 0v5a.5.5 0 0 0 .5.5z"/>
            </svg></a></p>

    <p>© 2021  PointsPlotter. · <a href="https://github.com/aANAESTHESIAa">Сайт разработчика</a>

    </p>
    <p><a href="http://www.ccfebras.ru">«Вычислительный центр дальневосточного отделения Российской академии наук»</a></p>
</footer>
</div>
</body>
</html>

<!--https://stackoverflow.com/questions/44990517/displaying-json-data-in-chartjs-->