$("#errorbox").hide();
$("#expdetail").hide();
$("#edudetail").hide();

var currenttab = 0;
showTab(currenttab);

function showTab(n){
    var tab = document.getElementsByClassName("tab");
    
    for (i = 0; i < tab.length; i++){
        tab[i].style.display = "none";
    }

    console.log("CurrentTab: "+currenttab == tab.length);

    tab[n].style.display = "block";

    if(n == 0){
        document.getElementById("btnSubmit").style.display = "none";
        document.getElementById("btnPrev").style.display = "none";
        document.getElementById("btnNext").style.display = "inline";
    }else if(n == 3){
        document.getElementById("btnSubmit").style.display = "inline";
        document.getElementById("btnPrev").style.display = "inline";
        document.getElementById("btnNext").style.display = "none";
    }else{
        document.getElementById("btnSubmit").style.display = "none";
        document.getElementById("btnPrev").style.display = "inline";
        document.getElementById("btnNext").style.display = "inline";
    }

    fixStepIndicator(n)
}

function nextPrev(n){
    var tab = document.getElementsByClassName("tab");
    if(currenttab != 0){
        if (n == 1 && !validateForm()) return false;
    }

    tab[currenttab].style.display = "none";
    currenttab = currenttab + n;

    console.log(currenttab);

    if (currenttab > tab.length) {
        currenttab = currenttab - n;
        return false;
    }

    showTab(currenttab);
}

function fixStepIndicator(n){
    var i, step = document.getElementsByClassName("step");
    for (i = 0; i < step.length; i++){
        step[i].className = step[i].className.replace(" active", "");
    }

    step[n].className += " active";
}

function validateForm(){
    var x, y, i, valid = true;

    x = document.getElementsByClassName("tab");
    y = x[currenttab].getElementsByTagName("input");
    z = x[currenttab].getElementsByTagName("select");

    for (i = 0; i < y.length; i++) {
        y[i].className = y[i].className.replace(" invalid", "");
    }

    for (i = 0; i < z.length; i++) {
        z[i].className =  z[i].className.replace(" invalid", "");
    }

    for (i = 0; i < y.length; i++) {
        console.log(y[i].name);
        if (y[i].required == true && y[i].value == "") {
            y[i].className += " invalid";
            valid = false;
        }
        console.log(valid);
    }

    for (i = 0; i < z.length; i++) {
        console.log(z[i].name);
        if (z[i].required == true && z[i].value == "") {
            z[i].className += " invalid";
            valid = false;
        }
        console.log(valid);
    }

    if (valid) {
        document.getElementsByClassName("step")[currenttab].className += " finish";
    }
    
    return valid;
}

$(function () {
    $('#datetimepicker').datetimepicker({
        viewMode: 'years',
        format: 'yyyy-mm-dd',
        weekStart: 0,
        autoclose: 1,
        startView: 4,
        minView: 2,
        forceParse: 1,
        locale: 'th'
    });
    moment().format();

    $('#start').datetimepicker({
        viewMode: 'years',
        format: 'yyyy-mm',
        weekStart: 0,
        autoclose: 1,
        startView: 4,
        minView: 3,
        forceParse: 1,
        locale: 'th'
      });
  
      $('#end').datetimepicker({
        viewMode: 'years',
        format: 'yyyy-mm',
        weekStart: 0,
        autoclose: 1,
        startView: 4,
        minView: 3,
        forceParse: 1,
        locale: 'th'
      });
      moment().format();
});

$('select#edu').on('change', function(){
    console.log($(this).val());
    if($(this).val() >= 1){
        $("#edudetail").show();
        $("#edudetail input").prop('required', true);
    }else{
        $("#edudetail").hide();
        $("#edudetail input").prop('required', false);
    }
});

$('select#exp').on('change', function(){
    console.log($(this).val());
    if($(this).val() >= 0){
        $("#expdetail").show();
        $("#expdetail input").prop('required', true);
        $("#expdetail input#now").prop('required', false);
    }else{
        $("#expdetail").hide();
        $("#expdetail input").prop('required', false);
    }
});

$('#now').click(function(){
    if($(this).is(":checked")) {
      $("#end").prop('disabled', true);
      $("#end").prop('required', false);
    }else{
      $("#end").prop('disabled', false);
      $("#end").prop('required', true);
    }
});