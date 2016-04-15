var UniSearchApp = angular.module('UniSearchApp', []);

UniSearchApp.controller('SearchUni', function ($scope,$http) {

    $scope.itemreq = [];
    $scope.itemsub = [];
    $scope.itemscore = [];
    //$scope.listreq = {req_id: "", req_name: ""};
    //$scope.listsub = {sub_id:"",sub_name:"", short_name: "",req_id:"",cat_id:"" };
    //$scope.listscore = {score_id:"",sign:"",grade:"",point:"",req_id:""};
    $scope.arrInput = [
        {
            listreq: {req_id: "", req_name: ""},
            listsub: {sub_id: "", sub_name: "", short_name: "", req_id: "", cat_id: ""},
            listscore: {score_id: "", sign: "", grade: "", point: "", req_id: ""},
            subOfReq:[],
            scoreOfSub:[],
            gradeA: "",
            gradeB: "",
            gradeC: "",
            gradeD: "",
            inp:"",
        }
    ];

    //Hàm search
    $scope.getinitdata = function(){
        $http.get('myphp/initconnectdata.php').success(function(data){
            $scope.itemreq = data[0];
            $scope.itemsub = data[1];
            $scope.itemscore = data[2];
            //$scope.itemreq = {
            //    reqselected : $scope.listreq[0]
            //};
            //console.log($scope.itemreq.reqselected)
            //$scope.itemsub = {
            //    arr_sub: data[1],
            //    subselected: $scope.listsub[0]
            //};
            //$scope.itemscore = {
            //    arr_score: data[2],
            //    scoreselected:$scope.listscore[0]
            //};
            //$scope.subOfReq = [];
            //$scope.scoreOfSub = [];
            //angular.forEach($scope.itemsub,function(value,key){
            //    if(value.req_id == $scope.itemreq.req_id )
            //        $scope.subOfReq.push(value);
            //});
            //angular.forEach($scope.itemscore,function(value,key){
            //    if(value.req_id == $scope.itemreq.req_id )
            //        $scope.scoreOfSub.push(value);
            //});
        }).error(function(data){
            console.log(data);
        });

    };
    $scope.ChangeSelectReq = function(s,item){

        $scope.arrInput[s].subOfReq = [];
        $scope.arrInput[s].scoreOfSub = [];
        angular.forEach($scope.itemsub, function (value, key) {
            if (value.req_id == item.req_id)
                $scope.arrInput[s].subOfReq.push(value);
        });
        angular.forEach($scope.itemscore, function (value, key) {
            if (value.req_id == item.req_id)
                $scope.arrInput[s].scoreOfSub.push(value);
        });

        $scope.arrInput[s].listreq = item;
        //$scope.arrInput[s].dataReq = item,
        //
        //console.log($scope.arrInput)
        //var a = $("#subject-select #score-select").html();
        //console.log(a)
        //if($scope.itemreq.reqselected.req_id == 12){
        //    sr="<div id='input-select'>"
        //    sr+="Writting:<input type='number' style='margin-left: 5px; margin-right: 5px;' id='grades-a"+id+"' >"
        //    sr+="Computer:<input type='number' style='margin-left: 5px; margin-right: 5px;' id='grades-b"+id+"' >"
        //    sr+="Internet:<input type='number' style='margin-left: 5px; margin-right: 5px;' id='grades-c"+id+"' >"
        //    sr+="</div>"
        //    $("#requirement1 #input-select").replaceWith(sr);
        //}else{
        //    $("#input-select").replaceChild(a);
        //}

    };

    $scope.ChangeSelectSub = function(s,item){
        console.log($scope.arrInput[s])
        $scope.arrInput[s].listsub = item;
    };

    $scope.ChangeSelectScore = function(s,item){
        console.log($scope.arrInput[s])
        $scope.arrInput[s].listscore = item;
    };

    $scope.InsertRequirement = function(){
        d = {
            listreq: {req_id: "", req_name: ""},
            listsub: {sub_id: "", sub_name: "", short_name: "", req_id: "", cat_id: ""},
            listscore: {score_id: "", sign: "", grade: "", point: "", req_id: ""}
        }
        $scope.arrInput.push(d)
        //var x = $("#reuirement-select"+$scope.stt).html();
        ////var z = $("#input-subject").html();
        ////console.log(x)
        ////var y = "<div id='requirement"+stt+"'>"
        ////y+="<div>"
        ////y+="<div id='reuirement-select'>"
        ////y+=x
        ////y+="<div>"
        ////y+=    "<div id='input-subject'>"
        ////y+=         "<div id='subject-select' >"
        ////y+=         " <select id='entry-subject-select"+stt+"' ng-options='sub as sub.sub_name for sub in subOfReq track by sub.sub_id' ng-model='itemsub.subselected' ></select>"
        ////y+=         "</div>"
        ////y+=         "<div id='score-select'>"
        ////y+=         "<select id='entry-score-select"+stt+"' ng-options='sco as sco.sign for sco in scoreOfSub track by sco.score_id' ng-model='itemscore.scoreselected' ></select>"
        ////y+=         "</div>"
        ////y+=    "</div>"
        ////y+="</div>"
        ////y+="</div>"
        ////y+="</div>"
        //$("#container" ).append(y);
    };
    $scope.RemoveRequirement = function(){
        $scope.arrInput.splice($scope.arrInput[$scope.arrInput.length - 1],1);
    };

    $scope.Search = function(){
        var d = JSON.stringify($scope.arrInput);
        console.log(d)
        $.ajax({
            url: "myphp/Search.php",
            type: "post",
            // dataType: "json",
            data: {'data':d},
            success: function(data){
                $('#ketqua').html(data);
            }
        });
    }

    $scope.getinitdata();
    //$scope.Search = function() {
    //
    //    var req = {};
    //    var grade = {};
    //    // var point = 0;
    //    // var grade_of_point =0;
    //    // var total = 0;
    //    var d = {};
    //
    //    var data = [];
    //    //Get list requirement from input
    //    for (var i = 1; i < stt + 1; i++) {
    //        if ($('#entry-requirement-select' + i).val() == 21)
    //        {
    //            d[i] = {
    //                'req_id': Number($('#entry-requirement-select' + i).val()),
    //                'grade': Number($('#grades' + i).val()),
    //                'grade_a': Number($('#grades-a' + i).val()),
    //                'grade_b': Number($('#grades-b' + i).val()),
    //                'grade_c': Number($('#grades-c' + i).val())
    //            }
    //            data.push(d[i]);
    //        }else{
    //
    //            var point = Number($('#point-'+i).val());
    //            var grade_of_point = Number($('#grade-of-point-'+i).val());
    //            var total = Number(point + grade_of_point);
    //            if(grade_of_point ==0)
    //                total= 0;
    //            d[i] = {
    //                'req_id': Number($('#entry-requirement-select' + i).val()),
    //                'grade': Number($('#grades' + i).val()),
    //                'grade_a': total
    //            }
    //            if (d[i].grade == 0 && d[i].grade_a==0)
    //            {
    //                alert("Input field require,please");
    //                return 0;
    //            }
    //            else
    //                data.push(d[i]);
    //        }
    //    }
    //    //Post list data requirement
    //    console.log(d)
    //    data = JSON.stringify(data);
    //    console.log(data)
    //    $.ajax({
    //        url: "myphp/Search.php",
    //        type: "post",
    //        // dataType: "json",
    //        data: {'data':data},
    //        success: function(data){
    //            $('#ketqua').html(data);
    //        }
    //    })
    //    //}
    //    //funtion insert requirement form
    //}
    //$scope.InsertRequirement = function(){
    //    stt = stt+1;
    //    console.log('ssss')
    //    str = "<div id ='requirement"+stt+"'>"
    //    str+= "<div id='input-require"+stt+"'>"
    //    str+= "<div>"
    //    str+= "<div id='select-subject'>"
    //    str+= "<select name='entry"+stt+"' id='entry-requirement-select"+stt+"' onchange='ChangeSelect("+stt+")'>"
    //    str+= "<option value='13' selected='selected'>UEC</option>"
    //    str+= "<option value='14'>SPM</option>"
    //    str+= "<option value='15'>O LEVEL</option>"
    //    str+= "<option value='16'>IB</option>"
    //    str+= "<option value='17'>Foundation Programme</option>"
    //    str+= "<option value='18'>Diploma Programme</option>"
    //    str+= "<option value='19'>A LEVEL </option>"
    //    str+= "<option value='20'>STPM</option>"
    //    str+= "<option value='21'>TOEFL</option>"
    //    str+= "<option value='22'>IELTS</option>"
    //    str+= "<option value='23'>GCE</option>"
    //    str+=  "<option value='24'>Average score</option>"
    //    str+=  "</select>"
    //    str+=    "</div>"
    //    str+=    "<div id='input-grade-subject'>"
    //    str+="<input type='number' id='grades"+stt+"'> OR "
    //    str+= "<select name='point' id='point-"+stt+"' >"
    //    str+=            "<option value='250'>A</option>"
    //    str+=            "<option value='200'>B</option>"
    //    str+=            "<option value='150'>C</option>"
    //    str+=            "<option value='100'>D</option>"
    //    str+=            "<option value='50'>E</option>"
    //    str+=        "</select> : "
    //    str+=            "<select type='number' id='grade-of-point-"+stt+"'>"
    //    str+=                "<option value='0' selected='selected' >0</option>"
    //    str+=                "<option value='1' >1</option>"
    //    str+=                "<option value='2' >2</option>"
    //    str+=                "<option value='3' >3</option>"
    //    str+=                "<option value='4' >4</option>"
    //    str+=                "<option value='5' >5</option>"
    //    str+=            "</select>"
    //    str+= "</div>"
    //    str+="</div>"
    //    str+="</div>"
    //    str+="</div>"
    //    str+="<br>"
    //    $( "#container" ).append(str);
    //}
    ////funtion delete requirement form
    //$scope.RemoveRequire = function(){
    //    $('#requirement'+stt).remove();
    //    stt= stt-1;
    //}
    ////Function change input when select subject TOEFL

});
