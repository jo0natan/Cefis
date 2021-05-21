<!doctype html>
<html ng-app="ui.bootstrap.Cefis">
  <head>
    <title>CEFIS - Jonatan</title>
  </head>
  <body>
<div ng-controller="CarouselCefis">
  <div style="height: 305px">
    <div uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
      <div uib-slide ng-repeat="slide in slides track by slide.id" index="slide.id">
        <img ng-src="{{slide.image}}" style="margin:auto;">
        <div class="carousel-caption">
          <h1>{{slide.text}}</h1>
          <h3>{{slide.sub}}</h3>
        
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <button type="button" class="btn btn-info" ng-click="addSlide()">Add Slide</button>
      <button type="button" class="btn btn-info" ng-click="randomize()">Randomize slides</button>
      
    </div>
    <!--<div class="col-md-6">
      Interval, in milliseconds: <input type="number" class="form-control" ng-model="myInterval">
      <br />Enter a negative number or 0 to stop the interval.
    </div>-->
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular-animate.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular-sanitize.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
    <script>var cefis_json= <?php echo $json; ?>;</script>
    <script src="app/js/index2.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  </body>
</html>
