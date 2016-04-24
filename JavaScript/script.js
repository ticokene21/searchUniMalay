var UniSearchApp = angular.module('UniSearchApp', []);

UniSearchApp.controller('SearchUni', function ($scope,$http) {

    $scope.result = [];
    $scope.itemreq = [];
    $scope.itemsub = [];
    $scope.itemscore = [];
    $scope.a = [];
    $scope.b = [];
    // Create model data
    $scope.arrData = [{
        listreq:{
            listsub:[{
                score:{},
            }],

        },
        gradeA: "",
        gradeB: "",
        gradeC: "",
        gradeD: "",
    }];
    $scope.arrInput = [
        {
            listreq: {
                    req_id: "",
                    req_name: "",
                    listsub: [{
                        sub_id: "",
                        sub_name: "",
                        short_name: "",
                        req_id: "",
                        cat_id: "",
                    }],
                    score: [{
                        score_id: "",
                        sign: "",
                        grade: "",
                        point: "",
                        req_id: ""
                    }],

                },
            subOfReq:[],
            scoreOfSub:[],
            gradeA: "",
            gradeB: "",
            gradeC: "",
            gradeD: "",
            inp:"",
        }
    ];

    //Function get Requirement, subject, score
    $scope.getinitdata = function(){
        $http.get('myphp/initconnectdata.php').success(function(data){
            $scope.itemreq = data[0];
            $scope.itemsub = data[1];
            $scope.itemscore = data[2];
            console.log(data)

        }).error(function(data){
            console.log(data);
        });

    };
    //Function set value subject when input select subject
    $scope.ChangeSelectSub = function(s,s1,subitem){

        $scope.arrData[s].listreq.listsub[s1] = subitem;
        console.log($scope.arrData[s])
    };
    //Function set value score when input select subject
    $scope.ChangeSelectScore = function(s,s1,scoreitem){

        $scope.arrData[s].listreq.listsub[s1].score = scoreitem;
        console.log($scope.arrData)
    };
    //function Insert field input sub and score
    $scope.InsertSubScore = function(s,item){
        var sub ={
            sub_id: "",
            sub_name: "",
            short_name: "",
            req_id: "",
            cat_id: "",
            score : {
                score_id: "",
                sign: "",
                grade: "",
                point: "",
                req_id: ""
            },
        };


        $scope.arrData[s].listreq.listsub.push(sub);


        console.log($scope.arrData[s])
    };
    //Remove sub and score
    $scope.RemoveSubScore = function(s,item){

        $scope.arrData[s].listreq.listsub.splice($scope.arrData[s].listreq.listsub.length -1,1);

    };


    $scope.ChangeSelectReq = function(s,item){
        $scope.arrInput[s].listreq.listsub = [{
            sub_id: "",
            sub_name: "",
            short_name: "",
            req_id: "",
            cat_id: "",
            score : {
                score_id: "",
                sign: "",
                grade: "",
                point: "",
                req_id: ""
            }
        }];

        $scope.arrInput[s].subOfReq =[];
        $scope.arrInput[s].scoreOfSub=[];
        console.log()
        angular.forEach($scope.itemsub, function (value, key) {
            if (value.req_id == item.req_id)
                $scope.arrInput[s].subOfReq.push(value);
        });
        angular.forEach($scope.itemscore, function (value, key) {
            if (value.req_id == item.req_id)
                $scope.arrInput[s].scoreOfSub.push(value);
        });

        $scope.arrData[s].listreq = item;


    };

    $scope.InsertRequirement = function(){
        d = {
            listreq: {
                req_id: "",
                req_name: "",
                listsub: [{
                    sub_id: "",
                    sub_name: "",
                    short_name: "",
                    req_id: "",
                    cat_id: "",
                    score: {
                        score_id: "",
                        sign: "",
                        grade: "",
                        point: "",
                        req_id: ""
                    }
                }],

            },
            subOfReq:[],
            scoreOfSub:[],
            gradeA: "",
            gradeB: "",
            gradeC: "",
            gradeD: "",
            inp:""
        };
        d1 = {
            listreq:{
                listsub:{
                    score:{},
                },

            },
            gradeA: "",
            gradeB: "",
            gradeC: "",
            gradeD: ""
        }
        $scope.arrInput.push(d);
        $scope.arrData.push(d1);

    };

    $scope.RemoveRequirement = function(){
        $scope.arrInput.splice($scope.arrInput.length - 1,1);
        $scope.arrData.splice($scope.arrData.length - 1,1);
    };

    $scope.Search = function(){
        console.log($scope.arrData)
        var d = JSON.stringify($scope.arrData);
        console.log(d)

        console.log($.param({"data": d}))
        var request = $http({
            method: "post",
            url: 'myphp/Search.php',
            data: $.param({"data": d}),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).success(function(data){

            $("#kq").html(data.fragment);
        }).error(function(data){
            console.log(data)
        });
    };

    $scope.getinitdata();


});

