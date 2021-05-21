var app = angular.module("ui.bootstrap.demo", ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);
app.controller('CarouselDemoCtrl', function($scope, $http) {
    $scope.myInterval = 5000;
    $scope.noWrapSlides = false;
    $scope.active = 0;
    var slides = $scope.slides = [];
    var currIndex = 0;

    $scope.addSlide = function() {
        var newWidth = 600 + slides.length + 1;

        $http({
            method: 'GET',
            url: 'https://cefis.com.br/api/v1/event'
        }).success(function(data) {

            console.log(data.data[currIndex].title);
            slides.push({
                image: data.data[currIndex].banner,
                text: [data.data[currIndex].title][data.data[currIndex].title.length % 4],

                id: currIndex++
            });


        }).error(function(data) {
            console.log('error');
        });

    };

    $scope.randomize = function() {
        var indexes = generateIndexesArray();
        assignNewIndexesToSlides(indexes);
    };

    for (var i = 0; i < 4; i++) {
        $scope.addSlide();
    }

    function assignNewIndexesToSlides(indexes) {
        for (var i = 0, l = slides.length; i < l; i++) {
            slides[i].id = indexes.pop();
        }
    }

    function generateIndexesArray() {
        var indexes = [];
        for (var i = 0; i < currIndex; ++i) {
            indexes[i] = i;
        }
        return shuffle(indexes);
    }

    function shuffle(array) {
        var tmp, current, top = array.length;

        if (top) {
            while (--top) {
                current = Math.floor(Math.random() * (top + 1));
                tmp = array[current];
                array[current] = array[top];
                array[top] = tmp;
            }
        }

        return array;
    }
});