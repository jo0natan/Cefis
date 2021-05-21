<!DOCTYPE html>
<html lang="en" ng-app="App">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link rel="stylesheet" href="../assets/scss/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
    <script src="app/js/app2.js"></script>
</head>
<body class="container" ng-controller="mainController">
    <header>
        <a id="logo" href="www.google.com"><img src="images/logo.png" alt="logo"></a>
       
    </header>
    <main>
        <div class="wrapper">
            <div id="list">
        
                <ul id="mainList" ng-show="api" class="slideInDown" ng-init="limit = 3">
                    <li ng-repeat="api in api | limitTo: limit">
                        <figure>
                            <img style="width: 50%;" src="{{api.banner}}" alt="{{api.title}}">
                        </figure>

                        <div class="infoLine {{api.type}}">
                            <a class="userName" href="#">{{api.title}}</a>
                           
                        </div>

                        <div class="whenWhat">
                            <span>
                                com: {{api.teachers_names}}                                
                            </span>
                           
                        </div>
                    </li>
                </ul>
            </div>
            <a id="loadMore" href="#" ng-show="loadmore" ng-click="loadmore = true ; limit = api.length" ng-class="{ active: api }">Load More</a>
        </div>
    </main>
</body>
</html>

<?php echo $json; ?>
