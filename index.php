<?php
/**
 * Created by PhpStorm.
 * User: Tosha
 * Date: 16.09.16
 * Time: 13:22
 */

?>

<html>
<head>
    <script type="text/javascript">
        var countOfFields = 0; // Текущее число полей
        var maxFieldLimit = 30; // Максимальное число возможных полей
        var record1Arr = []; // Массив с полями и референсами 1
        var record2Arr = []; // Массив с полями и референсами 2
        var analysisType = 0; // Тип анализа для передачи в POST

//        function deleteField(id) {
//            var delName = document.getElementById("name" + id);
//            var delVal = document.getElementById("val" + id);
//            delName.removeChild(delName);
//            delVal.removeChild(delVal);
//            countOfFields--;
//            return false;
//        }



        function addField() {
            if (countOfFields >= maxFieldLimit) {
                alert("Число полей достигло своего максимума = " + maxFieldLimit);
                return false;
            }
            countOfFields++;

            var name = document.createElement("div");
            var val = document.createElement("div");
            name.setAttribute("id" , "name" + countOfFields);
            val.setAttribute("id" , "val" + countOfFields);
            name.innerHTML = countOfFields + ".<input name=\"col_name[" + countOfFields + "]\" type=\"text\" /> <a onclick=\"return deleteField(" + countOfFields + ")\" href=\"#\">[X]</a>";
            val.innerHTML = countOfFields + ".<input name=\"col_val[" + countOfFields + "]\" type=\"text\" />";
            document.getElementById("colName").appendChild(name);
            document.getElementById("colVal").appendChild(val);
            return false;
        }
        function deleteField(id) {
            var delName = document.getElementById("name" + id);
            var delVal = document.getElementById("val" + id);
            delName.parentNode.removeChild(delName);
            delVal.parentNode.removeChild(delVal);
            countOfFields--;
            return false;
        }

//        $(document).ready(function(){
//            var val='11';
//            if ($('option[value="'+val+'"]').length!=0) {
//                alert('Элемент с таким value есть.')
//            };
//        });

        function addRecord() {

            var objSel = document.getElementById("recordName1");
            var id = parseInt(objSel.options[objSel.selectedIndex].value);
            if ( objSel.selectedIndex != -1)
            {
                //Если есть выбранный элемент, отобразить его значение (свойство value)
//                alert(objSel.options[objSel.selectedIndex].value);
            }

            var table = document.getElementById("recordTable");
            var row1 = table.insertRow(-1);
            row1.setAttribute("id", "recordRow"+id);
            var cell1 = row1.insertCell(0);
            var cell2 = row1.insertCell(1);
            cell2.setAttribute("id","cell"+id);
            var cell3 = row1.insertCell(2);
            cell3.setAttribute("id","recordType"+id);
            cell3.setAttribute("onclick", "return checkRecordType(" + id + ")");
            var cell4 = row1.insertCell(3);
            cell1.innerHTML = getName(id);
            cell3.innerHTML = "Общ.<input id=\"recordTypeVal" + id + "\" name=\"recordTypeVal" + id + "\" type=\"hidden\" value=\"0\"/>";
//            cell2.innerHTML = "<input name=\"recordText" + id + "\" type=\"text\" />";
//            cell3.innerHTML = "<input name=\"recordCheckbox" + id + "\" type=\"checkbox\" onclick=\"return deleteRecord(" + id + ")\"/> М+Ж";
            cell4.innerHTML = "<a onclick=\"return deleteRecord(" + id + ")\" href=\"#\">[X]</a>";

            createTable(id, "cell");
            twoVar(id, "recordCell");

            return false;
        }

        function createTable(id, name) {
            var div = document.getElementById("cell"+id);
            var tbl = document.createElement('table');
//            tbl.style.width = '100%';
            tbl.setAttribute('border', '1');
            tbl.setAttribute('id', name+'Table'+id);
            div.appendChild(tbl);

            return false;
        }

        function twoVar(id, name) {
            var table = document.getElementById("cellTable"+id);
            var row1 = table.insertRow(-1);
            row1.setAttribute("id", name+id)
            var cell1 = row1.insertCell(0);
            var cell2 = row1.insertCell(1);
            cell1.innerHTML = "<input name=\"min" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            cell2.innerHTML = "<input name=\"max" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
        }

        function fourVar(id, name){
            var table = document.getElementById("cellTable"+id);
            var row1 = table.insertRow(-1);
            row1.setAttribute("id", name+id)
            var cell1 = row1.insertCell(0);
            var cell2 = row1.insertCell(1);
            cell1.innerHTML = "<input name=\"min" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            cell2.innerHTML = "<input name=\"max" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            var row2 = table.insertRow(-1);
            row1.setAttribute("id", name+id)
            var cell3 = row2.insertCell(0);
            var cell4 = row2.insertCell(1);
            cell1.innerHTML = "<input name=\"min" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            cell2.innerHTML = "<input name=\"max" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
        }

        function fourVarInv(id, name){
            var table = document.getElementById("cellTable"+id);
            var row1 = table.insertRow(-1);
            row1.setAttribute("id", name+id)
            var cell1 = row1.insertCell(0);
            var cell2 = row1.insertCell(1);
            cell1.innerHTML = "<input name=\"min" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            cell2.innerHTML = "<input name=\"max" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            var row2 = table.insertRow(-1);
            row1.setAttribute("id", name+id)
            var cell3 = row2.insertCell(0);
            var cell4 = row2.insertCell(1);
            cell1.innerHTML = "<input name=\"min" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
            cell2.innerHTML = "<input name=\"max" + id + "\" type=\"text\" value=\""+id+"\" size=\"5\"/>";
        }

        function checkRecordType(id) {
            alert(id);
            var typeVal = document.getElementById("recordTypeVal"+id);
            var type = document.getElementById("recordType"+id);
            var intType = parseInt(typeVal.getAttribute("value"));
            alert(intType);
            switch (intType){
                case (0):
                    typeVal.setAttribute("value", "1");
                    type.innerHTML = "Ж+М<input id=\"recordTypeVal" + id + "\" name=\"recordTypeVal" + id + "\" type=\"hidden\" value=\"1\"/>";
                    deleteTables("recordCell"+id);
                    fourVar(id, "recordCell"+id);
                    break;
                case (1):
                    typeVal.setAttribute("value", "2");
                    type.innerHTML = "М+Ж<input id=\"recordTypeVal" + id + "\" name=\"recordTypeVal" + id + "\" type=\"hidden\" value=\"2\"/>";
                    deleteTables("recordCell"+id);
                    fourVarInv(id, "recordCell"+id);
                    break;
                case (2):
                    typeVal.setAttribute("value", "0");
                    type.innerHTML = "Общ.<input id=\"recordTypeVal" + id + "\" name=\"recordTypeVal" + id + "\" type=\"hidden\" value=\"0\"/>";
                    deleteTables("recordCell"+id);
                    twoVar(id, "recordCell"+id)
                    break;
                default:
                    break;
            }

        }

        function deleteRecord(id) {
            var delName = document.getElementById("recordRow" + id);
            delName.parentNode.removeChild(delName);
            return false;
        }

        function addFormula() {
            if (countOfFields >= maxFieldLimit) {
                alert("Число показателей достигло своего максимума = " + maxFieldLimit);
                return false;
            }
            countOfFields++;

//            var objSel = document.recordForm.recordName;
//            objSel.options[0] = new Option("Строка списка 0", "str0");
//            objSel.options[1] = new Option("Строка списка 1", "str1");
//            objSel.options[2] = new Option("Строка списка 2", "str2");

            var objSel = document.getElementById("recordName1");
            if ( objSel.selectedIndex != -1)
            {
                //Если есть выбранный элемент, отобразить его значение (свойство value)
                alert(objSel.options[objSel.selectedIndex].value);
            }

//            var recordName = document.getElementById("recordName")[0];
//            var old =  recordName.value;
//
//            alert("recordName" + old);

//            alert("recordName = " + sel);
            var name = document.createElement("div");
//            var val = document.createElement("div");
            name.setAttribute("id" , "name" + countOfFields);
//            val.setAttribute("id" , "val" + countOfFields);
            name.innerHTML = countOfFields + ".<input name=\"col_name[" + countOfFields + "]\" type=\"text\" /> <a onclick=\"return deleteField(" + countOfFields + ")\" href=\"#\">[X]</a>";
//            val.innerHTML = countOfFields + ".<input name=\"col_val[" + countOfFields + "]\" type=\"text\" />";
            document.getElementById("records1").appendChild(name);
//            document.getElementById("colVal").appendChild(val);
            return false;
        }

        function changeForm(){
            var objSel = document.analysisNameForm.analysisNameSel;
            var analysisVal = "";
            if ( objSel.selectedIndex != -1)
            {
                //Если есть выбранный элемент, отобразить его значение (свойство value)
//                alert(objSel.options[objSel.selectedIndex].value);
                analysisVal = objSel.options[objSel.selectedIndex].value;
            }
            if(analysisVal == "1"){
//                alert(objSel.options[objSel.selectedIndex].value);
//                alert("Выбран \"Клинический анализ крови\"");
                analysisType = 1;
                
                var table = document.getElementById("Main");
                var row1 = table.insertRow(-1);
                row1.setAttribute("id", "newLine1")
                var cell1 = row1.insertCell(0);
                var cell2 = row1.insertCell(1);
                cell1.innerHTML = "Добавить показатель";
                cell2.innerHTML = "<select id=\"recordName1\" name=\"recordName1\"></select><a onclick=\"return addRecord()\" href=\"#\">[+]</a>";

                var row2 = table.insertRow(-1);
                row2.setAttribute("id", "newLine2")
                var cell3 = row2.insertCell(0);
                var cell4 = row2.insertCell(1);
                cell3.innerHTML = "Лейкоцитарная формула";
                cell4.innerHTML = "<select id=\"recordName2\" name=\"recordName2\"></select><a onclick=\"return addRecord()\" href=\"#\">[+]</a>";

//                var objSel = document.recordForm.recordName;
                var objSel1 = document.getElementById("recordName1");
                objSel1.options[0] = new Option(getName(0), "0");
                objSel1.options[1] = new Option(getName(1), "1");
                objSel1.options[2] = new Option(getName(2), "2");
                objSel1.options[3] = new Option(getName(3), "3");
                objSel1.options[4] = new Option(getName(4), "4");
                objSel1.options[5] = new Option(getName(5), "5");

                var objSel2 = document.getElementById("recordName2");
                objSel2.options[0] = new Option(getName(6), "6");
                objSel2.options[1] = new Option(getName(7), "7");
                objSel2.options[2] = new Option(getName(8), "8");
                objSel2.options[3] = new Option(getName(9), "9");
                objSel2.options[4] = new Option(getName(10), "10");
                objSel2.options[5] = new Option(getName(11), "11");
                objSel2.options[6] = new Option(getName(12), "12");

                var div = document.getElementById("records1");
                var tbl = document.createElement('table');
//            tbl.style.width = '100%';
                tbl.setAttribute('border', '1');
                tbl.setAttribute('id', 'allTable');

                var tr1 = document.createElement('tr');
                tr1.setAttribute("id" , "recordSTR");
                tr1.setAttribute("align" , "center");
                var td1 = document.createElement('td');
                td1.appendChild(document.createTextNode("ОСНОВНЫЕ ПОКАЗАТЕЛИ"));
                tr1.appendChild(td1);
                tbl.appendChild(tr1);

                var tr2 = document.createElement('tr');
                tr2.setAttribute("id" , "recordTR");
                var td2 = document.createElement('td');
                td2.setAttribute("id", "recordTD");

                tr2.appendChild(td2);
                tbl.appendChild(tr2);

                var tr3 = document.createElement('tr');
                tr3.setAttribute("id" , "formulaSTR");
                tr3.setAttribute("align" , "center");
                var td3 = document.createElement('td');
                td3.appendChild(document.createTextNode("ЛЕЙКОЦИТАРНАЯ ФОРМУЛА"));
                tr3.appendChild(td3);
                tbl.appendChild(tr3);

                var tr4 = document.createElement('tr');
                tr4.setAttribute("id" , "formulaTR");
                var td4 = document.createElement('td');
                td4.setAttribute("id", "formulaTD");

                tr4.appendChild(td4);
                tbl.appendChild(tr4);

                div.appendChild(tbl);

                createRecordsTables("recordTD");
                createFormulaTables("formulaTD");




//                var new_1_1 = document.createElement("td");
//                new_1_1.setAttribute("id", "viewLine");
//                new_1_1.innerHTML = "Добавить показатель";
//                document.getElementById("projectTR_1").appendChild(new_1_1);
//                var new_1_2 = document.createElement("td");
//                new_1_2.setAttribute("id", "viewLine");
//                new_1_2.innerHTML = "<select id=\"recordName\" name=\"recordName\"></select><a onclick=\"return addRecord()\" href=\"#\">[+]</a>";
//                document.getElementById("projectTR_1").appendChild(new_1_2);
//
//                var new_2_1 = document.createElement("td");
//                new_2_1.setAttribute("id", "viewLine");
//                new_2_1.innerHTML = "Добавить показатель";
//                document.getElementById("projectTR_2").appendChild(new_2_1);
//                var new_2_2 = document.createElement("td");
//                new_2_2.setAttribute("id", "viewLine");
//                new_2_2.innerHTML = "<select id=\"recordName\" name=\"recordName\"><option value=\"11\">Клинический анализ крови</option><option value=\"22\">Биохимический анализ крови</option><option value=\"33\">Общий анализ мочи</option> </select><a onclick=\"return addRecord()\" href=\"#\">[+]</a>";
//                document.getElementById("projectTR_2").appendChild(new_2_2);

//                var td = document.createElement("td");
//                td.setAttribute("id", "viewRow");
//                document.projectForm.tr.appendChild(td);

//                var name = document.createElement("div");
//                name.setAttribute("id" , "name" + countOfFields);
//                name.innerHTML = countOfFields + ".<input name=\"col_name[" + countOfFields + "]\" type=\"text\" /> <a onclick=\"return deleteField(" + countOfFields + ")\" href=\"#\">[X]</a>";
//                document.getElementById("projectTR").appendChild(name);
                return false;
            }

            if(analysisVal == "2"){
                alert(objSel.options[objSel.selectedIndex].value);

                deleteRows();
                deleteTables("allTable");
                return false;
            }

            if(analysisVal == "3"){
                alert(objSel.options[objSel.selectedIndex].value);

                deleteRows();
                return false;
            }
        }

        function createRecordsTables(id) {
            var div = document.getElementById(id);
            var tbl = document.createElement('table');
//            tbl.style.width = '100%';
            tbl.setAttribute('border', '1');
            tbl.setAttribute('id', 'recordTable');
            var tr = document.createElement('tr');
            tr.setAttribute("id" , "record");

            var td = document.createElement('td');
            td.appendChild(document.createTextNode("Показатель"));
            tr.appendChild(td);

            var td2 = document.createElement('td');
            td2.appendChild(document.createTextNode("Референсные значения"));
            tr.appendChild(td2);

            var td3 = document.createElement('td');
            td3.appendChild(document.createTextNode(""));
            tr.appendChild(td3);

            var td4 = document.createElement('td');
            td4.appendChild(document.createTextNode(""));
            tr.appendChild(td4);

            tbl.appendChild(tr);
            div.appendChild(tbl);

            return false;
        }

        function createFormulaTables(id) {
            var div_f = document.getElementById(id);
            var tbl_f = document.createElement('table');
//            tbl.style.width = '100%';
            tbl_f.setAttribute('border', '1');
            tbl_f.setAttribute('id', 'formulaTable');
            var tr_f = document.createElement('tr');
            tr_f.setAttribute("id" , "formula");

            var td_f = document.createElement('td');
            td_f.appendChild(document.createTextNode("Показатель"));
            tr_f.appendChild(td_f);

            var td_f2 = document.createElement('td');
            td_f2.appendChild(document.createTextNode("Референсные значения"));
            tr_f.appendChild(td_f2);

            var td_f3 = document.createElement('td');
            td_f3.appendChild(document.createTextNode(""));
            tr_f.appendChild(td_f3);

            var td_f4 = document.createElement('td');
            td_f4.appendChild(document.createTextNode(""));
            tr_f.appendChild(td_f4);

            tbl_f.appendChild(tr_f);
            div_f.appendChild(tbl_f);
        }

        function deleteRows(){
            var row1 = document.getElementById("newLine1");
            row1.parentNode.removeChild(row1);

            var row2 = document.getElementById("newLine2");
            row2.parentNode.removeChild(row2);

            return false;
        }

        function deleteTables(id){
            var table = document.getElementById(id);
            table.parentNode.removeChild(table);

            return false;
        }

        function getName(id) {
            var name = "";
            switch (id){
                case 0:
                    name = "Гемоглобин";
                    break;
                case 1:
                    name = "Эритроциты";
                    break;
                case 2:
                    name = "Гематокрит";
                    break;
                case 3:
                    name = "Лейкоциты";
                    break;
                case 4:
                    name = "Тромбоциты";
                    break;
                case 5:
                    name = "СОЭ (по Вестергрену)";
                    break;
                case 6:
                    name = "Палочкоядерный нейтрофилы";
                    break;
                case 7:
                    name = "Сегментоядерные нейтрофилы";
                    break;
                case 8:
                    name = "Нейтрофилы (общее кол-во)";
                    break;
                case 9:
                    name = "Эозинофилы";
                    break;
                case 10:
                    name = "Базофилы";
                    break;
                case 11:
                    name = "Моноциты";
                    break;
                case 12:
                    name = "Лимфоциты";
                    break;
                default:
                    break;
            }

            return name;
        }

    </script>
</head>
<title>BioEq Laboratory</title>
<body>
<table border="1" width="100%">
    <tr>
        <td align="center" width="20%" height="10%"><img src="unnamed.png"></td>
        <td align="center" valign="middle"><font size="5"><i>BioEq Laboratory</i></font></td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <br>
                <table border="1" id="Main">
                    <tr>
                        <td>Анализ</td>
                        <td>
                            <form id="analysisNameForm" name="analysisNameForm">
                                <select name="analysisNameSel" onchange="changeForm()">
                                    <option value="0">Выберите анализ</option>
                                    <option value="1">Клинический анализ крови</option>
                                    <option value="2">Биохимический анализ крови</option>
                                    <option value="3">Общий анализ мочи</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <form id="projectForm" name="projectForm" method="get">
                        <tr>
                            <td>Проект</td>
                            <td><input type="text" size="30" name="projectName"></td>
                        </tr>
                        <tr>
                            <td>Протокол</td>
                            <td><input type="text" size="30" name="protocolName"></td>
                        </tr>
                        <tr>
                            <td>Время доставки</td>
                            <td><input type="text" size="30" name="deliveryTime"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="button" value="Сформировать"></td>
                        </tr>


                </table>
            <br><br>

            <div id="records1">

            </div>
            </form>
        </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
</body>
</html>
