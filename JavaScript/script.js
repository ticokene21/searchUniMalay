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
                'grade': Number($('#grades' + i).val())
            }
            data.push(d[i])
        }
        data = JSON.stringify(data);
        console.log(data)
        $.ajax({
            url: "myphp/Search.php",
            type: "post",
            dataType: "text",
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
        str+= "<select name='entry"+stt+"' id='entry-requirement-select"+stt+"'>"
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
        str+="<label for='' id='your-grades'>Your grades/expected grades?</label>"
        str+="<input type='number' id='grades"+stt+"'><br>"
        str+="</div>"
        console.log(str)
        $( "#container" ).append(str);
    }
    //Xóa requirement
    function RemoveRequire(){
        $('#requirement'+stt).remove();
        stt= stt-1;
    }
// });
