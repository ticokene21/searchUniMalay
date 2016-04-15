
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
                    <div id="reuirement-select">
                        <select id="entry-requirement-select{{$index}}" ng-options="req as req.req_name for req in itemreq track by req.req_id" ng-model="arr.listreq" ng-change="ChangeSelectReq($index,arr.listreq)"></select>
                    </div>
                    <div id="input-subject" ng-if="arr.listreq.req_id == 12" >
                        Writting:<input type="number" style="margin-left: 5px; margin-right: 5px;" id="grades-a{{$index}}" >
                        Computer:<input type="number" style="margin-left: 5px; margin-right: 5px;" id="grades-a{{$index}}" >
                        Internet:<input type="number" style="margin-left: 5px; margin-right: 5px;" id="grades-a{{$index}}" >
                    </div>
                    <div id="input-subject" ng-if="arr.listreq.req_id != 12">
                        <div id="subject-select" >
                            <select id="entry-subject-select{{$index}}" ng-options="sub as sub.sub_name for sub in arr.subOfReq track by sub.sub_id" ng-model="arr.listsub" ng-change="ChangeSelectSub($index,arr.listsub)"></select>
                        </div>
                        <div id="score-select">
                            <select id="entry-score-select{{$index}}" ng-options="sco as sco.sign for sco in arr.scoreOfSub track by sco.score_id" ng-model="arr.listscore" ng-change="ChangeSelectScore($index,arr.listscore)"></select>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        <br>
    </div>
    <button  ng-click="InsertRequirement()">+</button>
    <button  ng-click="RemoveRequirement()">-</button>
    <button  ng-click="Search()">Search</button>
</div>

<h4 id="ketqua"></h4>
</body>
</html>