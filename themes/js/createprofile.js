$("#errorbox").hide();

var currenttab = 0;
showTab(currenttab);

function showTab(n){
    var tab = document.getElementsByClassName("tab");
    
    for (i = 0; i < tab.length; i++){
        tab[i].style.display = "none";
    }

    tab[n].style.display = "block";

    if(n == 0){
        document.getElementById("btnPrev").style.display = "none";
    }else{
        document.getElementById("btnPrev").style.display = "inline";
    }

    fixStepIndicator(n)
}

function nextPrev(n){
    var tab = document.getElementsByClassName("tab");
    // if (n == 1 && !validateForm()) return false;

    tab[currenttab].style.display = "none";
    currenttab = currenttab + n;
    if (currenttab >= tab.length) {
        document.getElementById("createProfileForm").submit();
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
});