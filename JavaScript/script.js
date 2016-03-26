// var UniSearchApp = angular.module('UniSearchApp', []);
// UniSearchApp.controller('SearchUni', function ($scope) {
//     console.log('âdasd')
    var stt = 1;
    //Hàm search
    function Search() {

        var req = {};
        var grade = {};

        //Biến này là lấy ID của requirement trong bảng Cou_Req
        // Biến này là biến valueorther trong bảng Cou_Req
        //Từ hai biến trên tìm couse_id
        var d = {};
        //Lấy list requirement
        var data = [];
        for (var i = 1; i < stt + 1; i++) {
            //req[i] = $('#entry-requirement-select'+i).val();
            //grade[i] = $('#grades'+i).val();
            //d.push(req[i]);
            //d1.push(grade[i]);
            d[i] = {
                'req_id': Number($('#entry-requirement-select' + i).val()),
                'grade': Number($('#grades' + i).val()),
                'grade_a': Number($('#grades-a' + i).val()),
                'grade_b': Number($('#grades-b' + i).val()),
                'grade_c': Number($('#grades-c' + i).val())
            }
            data.push(d[i]);
        }
        console.log(d)
        data = JSON.stringify(data);
        console.log(data)
        $.ajax({
            url: "myphp/Search.php",
            type: "post",
            // dataType: "json",
            data: {'data':data},
            success: function(data){
                $('#ketqua').html(data);
            }
        })
        //}
        //Hàm thêm requirement
    }
    function InsertRequirement(){
        stt = stt+1;
        console.log('ssss')
        str = "<div id ='requirement"+stt+"'>"
        str+= "<label for='' id='entry-requirements'>Entry Requirements</label>";
        str+= "<select name='entry"+stt+"' id='entry-requirement-select"+stt+"' onchange='ChangeSelect("+stt+")'>"
        str+= "<option value='13' selected='selected'>UEC</option>"
        str+= "<option value='14'>SPM</option>"
        str+= "<option value='15'>O LEVEL</option>"    
        str+= "<option value='16'>IB</option>"
        str+= "<option value='17'>Foundation Programme</option>"
        str+= "<option value='18'>Diploma Programme</option>"
        str+= "<option value='19'>A LEVEL </option>"
        str+= "<option value='20'>STPM</option>"
        str+= "<option value='21'>TOEFL</option>"
        str+= "<option value='22'>IELTS</option>"
        str+= "<option value='23'>GCE</option>"
        str+=  "<option value='24'>Average score</option>"
        str+=  "</select>"
        str+= "<div id='input-require"+stt+"'>"
        str+= "<div>"
        str+="<label for='' id='your-grades'>Your grades/expected grades?</label>"
        str+="<input type='number' id='grades"+stt+"'><br>"
        str+="</div>"
        str+="</div>"
        str+="</div>"
        console.log(str)
        $( "#container" ).append(str);
    }
    //Xóa requirement
    function RemoveRequire(){
        $('#requirement'+stt).remove();
        stt= stt-1;
    }

    function ChangeSelect(id)
    {

        if($('#entry-requirement-select' + id).val() ==21)
        {
            sr="<div>"
            sr+="<label for='' id='your-grades'>Your grades/expected grades?</label>"
            sr+="Writting<input type='number' id='grades-a"+id+"' >"
            sr+="Computer<input type='number' id='grades-b"+id+"' >"
            sr+="Internet<input type='number' id='grades-c"+id+"' >"
            sr+="</div>"
            $("#input-require"+id+" div").replaceWith(sr);
        }else{
            s="<div>"
            s+="<label for='' id='your-grades'>Your grades/expected grades?</label>"
            s+="<input type='number' id='grades"+id+"'><br>"
            s+="</div>"
            $("#input-require"+id+" div").replaceWith(s);
        }
    }
// });
