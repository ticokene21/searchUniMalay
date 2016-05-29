<!DOCTYPE html>
<html lang="en" ng-app="UniSearchApp" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="Static/bootstrap-3.3.6-dist/css/bootstrap.min.css">
    <script src="JavaScript/jquery-2.1.4.min.js"></script>
    <script src="JavaScript/angular.min.js"></script>
    <script src="JavaScript/script.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
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

                    <div class="col-md-5" ng-if="arr.listreq.input_type == 1" >
                        <div class="subject-select" ng-repeat="sub in arr.listreq.listsub">
                            <select class="entry-subject-select" ng-options="sub as sub.sub_name for sub in arr.subOfReq track by sub.sub_id" ng-model="sub" ng-change="ChangeSelectSub($parent.$index,$index,sub)"></select>
<!--                            <div ng-if="arr.listreq.option == 0">OR Any: <input style="width: 50px" type="number"></div>-->
                            <div>
                            Grade:<select class="entry-score-select" ng-options="sco as sco.sign for sco in arr.scoreOfSub track by sco.score_id" ng-model="sub.score" ng-change="ChangeSelectScore($parent.$index,$index,sub.score)"></select>
                            </div>

                        </div>
                    </div>
<!--                    <div class="col-md-4" ng-if="arr.listreq.input_type== 4">-->
<!--                        <div class="subject-select">-->
<!--                            <div class="row">-->
<!--                                <div class="col-md-2">Point: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.overall" ng-init="sub.scoreEnglish.overall = 0" ></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col-md-4" ng-if="arr.listreq.input_type == 2 " >
                        <div class="subject-select" ng-repeat="sub in arr.listreq.listsub">
                            <select class="entry-subject-select" ng-options="sub as sub.sub_name for sub in arr.subOfReq track by sub.sub_id" ng-model="sub" ng-change="ChangeSelectSub($parent.$index,$index,sub)"></select>
<!--                            <select class="entry-score-select" ng-options="sco as sco.sign for sco in arr.scoreOfSub track by sco.score_id" ng-model="sub.score" ng-change="ChangeSelectScore($parent.$index,$index,sub.score)"></select>-->
                            <div class="row"  ng-if="arr.listreq.req_id == 7" >
                                <div class="col-md-2">Overall: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.overall" ng-init="sub.scoreEnglish.overall = 0" ></div>
                                <div class="col-md-2">Writing: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.writing" ng-init="sub.scoreEnglish.writing = 0" ></div>
                                <div class="col-md-2">Listening: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.listening" ng-init="sub.scoreEnglish.listening = 0"></div>
                                <div class="col-md-2">Reading: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.reading" ng-init="sub.scoreEnglish.reading = 0"></div>
                                <div class="col-md-2">Speaking: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.speaking" ng-init="sub.scoreEnglish.speaking = 0"></div>
                            </div>
                            <div class="row" ng-if="arr.listreq.req_id ==11" >
                                <div class="col-md-8">Grade: <input style="width: 50px" type="number" ng-model="sub.scoreEnglish.overall" ng-init="sub.scoreEnglish.overall = 0 && sub.scoreEnglish.writing = 0 && sub.scoreEnglish.listening = 0 && sub.scoreEnglish.reading = 0 && sub.scoreEnglish.speaking = 0 " > {{sub.unit}}</div>
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
        <button  ng-click="Update()">Update</button>
    </div>

</div>

<div ng-if="vm.items != null">
    <table>
        <tr>
            <th>Course</th>
            <th>Level</th>
            <th>Group</th>
            <th>School</th>
            <th>Requirement</th>
        </tr>
        <tr ng-repeat="uni in vm.items track by $index">
            <td>{{uni.uniname}}</td>
            <td>{{uni.cou_name}}</td>
            <td>{{uni.group_name}}</td>
            <td>{{uni.level_name}}</td>
            <td></td>
        </tr>
    </table>
    <divng-repeat="un in vm.items track by $index">{{un}}</div>
    <ul ng-if="vm.pager.pages.length" class="pagination">
        <li ng-class="{disabled:vm.pager.currentPage === 1}">
            <a ng-click="vm.setPage(1)">First</a>
        </li>
        <li ng-class="{disabled:vm.pager.currentPage === 1}">
            <a ng-click="vm.setPage(vm.pager.currentPage - 1)">Previous</a>
        </li>
        <li ng-repeat="page in vm.pager.pages" ng-class="{active:vm.pager.currentPage === page}">
            <a ng-click="vm.setPage(page)">{{page}}</a>
        </li>
        <li ng-class="{disabled:vm.pager.currentPage === vm.pager.totalPages}">
            <a ng-click="vm.setPage(vm.pager.currentPage + 1)">Next</a>
        </li>
        <li ng-class="{disabled:vm.pager.currentPage === vm.pager.totalPages}">
            <a ng-click="vm.setPage(vm.pager.totalPages)">Last</a>
        </li>
    </ul>
</div>
</body>
</html>
