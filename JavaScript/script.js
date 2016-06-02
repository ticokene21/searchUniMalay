var UniSearchApp = angular.module('UniSearchApp', []);
//UniSearchApp.factory('PagerService',);

UniSearchApp.controller('SearchUni', function ($scope,$http) {

    $scope.result = [];
    $scope.itemreq = [];
    $scope.itemsub = [];
    $scope.itemscore = [];
    $scope.itemlevel ={};
    $scope.itemgroup = {};
    $scope.arr_univer = [];
    $scope.b = [];
    $scope.vm = [];
    $scope.requirement = {};
    $scope.level = {};
    $scope.group = {};
    //$scope_LoadCourseID = function() {
    //
    //    $http.get("myphp/uni.php").success(function (data) {
    //        $scope.result = data
    //    });
    //}
    function PagerService() {
        // service definition
        var service = {};

        service.GetPager = GetPager;

        return service;

        // service implementation
        function GetPager(totalItems, currentPage, pageSize) {
            // default to first page
            currentPage = currentPage || 1;

            // default page size is 10
            pageSize = pageSize || 10;

            // calculate total pages
            var totalPages = Math.ceil(totalItems / pageSize);

            var startPage, endPage;
            if (totalPages <= 10) {
                // less than 10 total pages so show all
                startPage = 1;
                endPage = totalPages;
            } else {
                // more than 10 total pages so calculate start and end pages
                if (currentPage <= 6) {
                    startPage = 1;
                    endPage = 10;
                } else if (currentPage + 4 >= totalPages) {
                    startPage = totalPages - 9;
                    endPage = totalPages;
                } else {
                    startPage = currentPage - 5;
                    endPage = currentPage + 4;
                }
            }

            // calculate start and end item indexes
            var startIndex = (currentPage - 1) * pageSize;
            var endIndex = startIndex + pageSize;

            // create an array of pages to ng-repeat in the pager control
            var pages = _.range(startPage, endPage + 1);

            // return object with all pager properties required by the view
            return {
                totalItems: totalItems,
                currentPage: currentPage,
                pageSize: pageSize,
                totalPages: totalPages,
                startPage: startPage,
                endPage: endPage,
                startIndex: startIndex,
                endIndex: endIndex,
                pages: pages
            };
        }
    }
    // Create model data

    function ExampleController(data) {
        $scope.vm = new PagerService();

        $scope.vm.dummyItems = data; // dummy array of items to be paged
        $scope.vm.pager = {};
        $scope.vm.setPage = setPage;
        console.log()
        initController();

        function initController() {
            // initialize to page 1
            $scope.vm.setPage(1);
        }

        function setPage(page) {
            if (page < 1 || page > $scope.vm.pager.totalPages) {
                return;
            }

            // get pager object from service
            $scope.vm.pager = $scope.vm.GetPager($scope.vm.dummyItems.length, page);

            // get current page of items
            $scope.vm.items = $scope.vm.dummyItems.slice($scope.vm.pager.startIndex, $scope.vm.pager.endIndex);
        }
    }


    $scope.arrData = [{
        listreq:{
            input_type: "",
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
                    input_type: "1",
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
            $scope.itemgroup = data[3];
            $scope.itemlevel = data[4];
            $scope.level = $scope.itemlevel[0];
            $scope.group = $scope.itemgroup[0];
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

    };

    $scope.InsertRequirement = function(){
        d = {
            listreq: {
                req_id: null,
                req_name: null,
                input_type: 1,
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

    $scope.loadCourseUni = function(){

        $http({
            method:"post",
            url:'myphp/uni.php',
            data: $.param({"data":$scope.result,"level":JSON.stringify($scope.level),"group":JSON.stringify($scope.group)}),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded',"Accept" : "application/json"}

        }).success(function(data){
            //$scope.arr_univer = data;
            //data.entry_requirements = $sce.trustAsHtml(data.entry_requirements);
            //console.log(data)

            ExampleController(data);

            console.log()
        }).error(function(data){
            console.log(data)
        });
    }


    $scope.Update = function(){
        var d = JSON.stringify($scope.arrData);
        var url = '';
        if(jQuery.isEmptyObject($scope.result))
            url = 'myphp/Search.php';
        else
            url = 'myphp/Update.php';

        var request = $http({
            method: "post",
            url: url,
            data: $.param({"data": d,"arr_result":$scope.result}),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).success(function(data){
            $scope.result = JSON.stringify(data);
            $scope.loadCourseUni();
        }).error(function(data){
            console.log(data)
        });
    };

    $scope.Search = function(){
        var d = JSON.stringify($scope.arrData);

        console.log(d)
        var request = $http({
            method: "post",
            url: 'myphp/Search.php',
            data: $.param({"data": d}),
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).success(function(data){
            $scope.result = JSON.stringify(data);
            $scope.loadCourseUni();
        }).error(function(data){
            console.log(data)
        });
    };

    $scope.getinitdata();


});

