<!DOCTYPE html>
<html lang="en" ng-app="UniSearchApp">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="JavaScript/jquery-2.1.4.min.js"></script>
    <script src="JavaScript/angular.min.js"></script>
    <script src="JavaScript/script.js"></script>
    <title></title>
</head>
<body ng-controller="SearchUni" >
<div >
    <div id="container">
        <div id="subject">
            <label for="" id="entry-requirements">Entry Requirements</label>
            <label for="" id="your-grades">Subject</label>
        </div>
        <div ng-repeat="arr in arrInput track by $index">
            <div id ="requirement{{$index}}">
                <div>
                    <div class="reuirement-select">
                        <select id="entry-requirement-select{{$index}}" ng-options="req as req.req_name for req in itemreq track by req.req_id" ng-model="arr.listreq" ng-change="ChangeSelectReq($index,arr.listreq)"></select>
                    </div>
                    <div id="input-subject">
                        <div class="subject-select" ng-repeat="sub in arr.listreq.listsub">
                            <select id="entry-subject-select{{$index}}" ng-options="sub as sub.sub_name for sub in arr.subOfReq track by sub.sub_id" ng-model="sub" ng-change="ChangeSelectSub($parent.$index,$index,sub)"></select>

                            <select id="entry-score-select{{$index}}" ng-options="sco as sco.sign for sco in arr.scoreOfSub track by sco.score_id" ng-model="sub.score" ng-change="ChangeSelectScore($parent.$index,$index,sub.score)"></select>
                        </div>
                    </div>
                </div>
            </div>
        <button  ng-click="InsertSubScore($index,arr.listreq)">+</button>
        <button  ng-click="RemoveSubScore($index,arr.listreq)">-</button>
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
