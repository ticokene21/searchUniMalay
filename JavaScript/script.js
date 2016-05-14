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
                sub_id: "0",
                score:{},
            }],
        }
    }];
    $scope.arrInput = [
        {
            listreq: {
                    req_id: "",
                    req_name: "",
                    listsub: [{
                        sub_id: null,
                        sub_name: "",
                        short_name: "",
                        req_id: "",
                        cat: "",
                    }],
                    score: [{
                        score_id: null,
                        sign: null,
                        grade: null,
                        point: null,
                        req_id: null
                    }],
                    //scoreEnglish: [{
                    //    overall: null,
                    //    writing: null,
                    //    listening: null,
                    //    reading: null,
                    //    speaking: null,
                    //}],
                    countsub: 0
                },
            subOfReq:[],
            scoreOfSub:[],
            //inp:"",
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
    $scope.SetOption = function(s,option){
        console.log(option);
        if(option == 0){
            $scope.arrData[s].listreq.option = 1;
            $scope.arrInput[s].listreq.option = 1;
        }else{
            $scope.arrInput[s].listreq.option = 0;
            $scope.arrData[s].listreq.option = 0;
        }
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
    $scope.InsertSubScore = function(s,item) {
        var sub = {
            sub_id: null,
            sub_name: null,
            short_name: null,
            req_id: null,
            cat: null,
            score: {
                score_id: null,
                sign: null,
                grade: null,
                point: null,
                req_id: null
            },
        };
        $scope.arrData[s].listreq.listsub.push(sub);
    };
    $scope.RemoveSubScore = function(s,item){

        $scope.arrData[s].listreq.listsub.splice($scope.arrData[s].listreq.listsub.length -1,1);

    };


    $scope.ChangeSelectReq = function(s,item){
        //$scope.arrInput[s].listreq.option = $scope.arrData[s].listreq.option;
        $scope.arrInput[s].listreq.listsub = [{
            sub_id: null,
            sub_name: null,
            short_name: null,
            req_id: null,
            cat: null,
            score : {
                score_id: null,
                sign: null,
                grade: null,
                point: null,
                req_id: null
            },
            scoreEnglish: {
                overall: null,
                writing: null,
                listening: null,
                reading: null,
                speaking: null,
            }
        }];

        $scope.arrInput[s].subOfReq =[];
        $scope.arrInput[s].scoreOfSub=[];

        angular.forEach($scope.itemsub, function (value, key) {
            if (value.req_id == item.req_id)
            {
                $scope.arrInput[s].subOfReq.push(value);
            }
        });
        angular.forEach($scope.itemscore, function (value, key) {
            if (value.req_id == item.req_id)
                $scope.arrInput[s].scoreOfSub.push(value);
        });

        $scope.arrData[s].listreq = item;
        $scope.arrData[s].listreq.countsub = 0;


    };

    $scope.InsertRequirement = function(){
        d = {
            listreq: {
                req_id: null,
                req_name: null,
                listsub: [{
                    sub_id: null,
                    sub_name: null,
                    short_name: null,
                    req_id: null,
                    cat: null,
                    score: {
                        score_id: null,
                        sign: null,
                        grade: null,
                        point: null,
                        req_id: null
                    },
                    scoreEnglish: {
                        overall: null,
                        writing: null,
                        listening: null,
                        reading: null,
                        speaking: null,
                    }
                }],
                countsub: 0
            },
            subOfReq:[],
            inp:null
        };
        d1 = {
            listreq:{
                listsub:{
                    sub_id: null,
                    score:{},
                    scoreEnglish:{}
                },

            },

        }
        $scope.arrInput.push(d);
        $scope.arrData.push(d1);

    };

    $scope.RemoveRequirement = function(){
        $scope.arrInput.splice($scope.arrInput.length - 1,1);
        $scope.arrData.splice($scope.arrData.length - 1,1);
    };

    $scope.Search = function(){
        var d = JSON.stringify($scope.arrData);
        //console.log($.param({"data": d}))
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

