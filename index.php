<!DOCTYPE html>
<html lang="en" ng-app="UniSearchApp" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="Static/bootstrap-3.3.6-dist/css/bootstrap.min.css">
    <script src="JavaScript/jquery-2.1.4.min.js"></script>
    <script src="JavaScript/angular.min.js"></script>
    <script src="JavaScript/script.js"></script>
    <title></title>
</head>
<body ng-controller="SearchUni" >
<div >
    <div id="container">
        <div class="row" id="subject">
            <label class="col-md-2" for="" id="entry-requirements">Entry Requirements</label>
            <label class="col-md-4" for="" id="your-grades">Subject</label>
        </div>
        <div ng-repeat="arr in arrInput track by $index" >
            <div id ="requirement">
                <div class="row"">
                    <div class="col-md-3">
                        <select class="entry-requirement-select" ng-options="req as req.req_name for req in itemreq track by req.req_id" ng-model="arr.listreq" ng-change="ChangeSelectReq($index,arr.listreq,arr.listreq.option)"></select>
                        <div style="margin-bottom: 10px">
                            <button  ng-click="InsertSubScore($index,arr.listreq)">+</button>
                            <button  ng-click="RemoveSubScore($index,arr.listreq)">-</button>
                        </div>
<!--                        <div style="margin-bottom: 10px">-->
<!--                            <button ng-click="SetOption($index,arr.listreq.option)">Option</button>-->
<!--                        </div>-->
                    </div>

                    <div class="col-md-5" ng-if="arr.listreq.req_id != 7" >
                        <class="subject-select" ng-repeat="sub in arr.listreq.listsub">
                            <select class="entry-subject-select" ng-options="sub as sub.sub_name for sub in arr.subOfReq track by sub.sub_id" ng-model="sub" ng-change="ChangeSelectSub($parent.$index,$index,sub)"></select>
<!--                            <div ng-if="arr.listreq.option == 0">OR Any: <input style="width: 50px" type="number"></div>-->
                            Grade:<select class="entry-score-select" ng-options="sco as sco.sign for sco in arr.scoreOfSub track by sco.score_id" ng-model="sub.score" ng-change="ChangeSelectScore($parent.$index,$index,sub.score)"></select>

                    </div>
                    <div class="col-md-4" ng-if="arr.listreq.req_id == 7" >
                        <div class="subject-select" ng-repeat="sub in arr.listreq.listsub">
                            <select class="entry-subject-select" ng-options="sub as sub.sub_name for sub in arr.subOfReq track by sub.sub_id" ng-model="sub" ng-change="ChangeSelectSub($parent.$index,$index,sub)"></select>
<!--                            <select class="entry-score-select" ng-options="sco as sco.sign for sco in arr.scoreOfSub track by sco.score_id" ng-model="sub.score" ng-change="ChangeSelectScore($parent.$index,$index,sub.score)"></select>-->
                            <div class="row">
                                <div class="col-md-2">Overall: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.overall" ng-init="sub.scoreEnglish.overall = 0" ></div>
                                <div class="col-md-2">Writing: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.writing" ng-init="sub.scoreEnglish.writing = 0" ></div>
                                <div class="col-md-2">Listening: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.listening" ng-init="sub.scoreEnglish.listening = 0"></div>
                                <div class="col-md-2">Reading: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.reading" ng-init="sub.scoreEnglish.reading = 0"></div>
                                <div class="col-md-2">Speaking: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.speaking" ng-init="sub.scoreEnglish.speaking = 0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br>
    </div>
    <div id="btn-group1">
        <button  ng-click="InsertRequirement()">+</button>
        <button  ng-click="RemoveRequirement()">-</button>
        <button  ng-click="Search()">Search</button>
    </div>

</div>

<div id="kq"></div>
</body>
</html>
