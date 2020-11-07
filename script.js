const teacherEls = document.querySelectorAll(".addTeacher");
const studentEls = document.querySelectorAll(".addStudent");


const roleStudentRadioEl = document.getElementById("role1");
const roleTeacherRadioEl = document.getElementById("role2");

teacherEls.forEach((El)=>
{
    El.style.display = "none";
    El.required = false;
});
studentEls.forEach((El)=>
{
    El.style.display = "block";
    El.required = true;
});


if(roleTeacherRadioEl)
{
    roleStudentRadioEl.addEventListener('click',()=>
    {
        teacherEls.forEach((El)=>
        {
            El.style.display = "none";
            El.required = false;
        });
        studentEls.forEach((El)=>
        {
            El.style.display = "block";
            El.required = true;
        });
    });


    roleTeacherRadioEl.addEventListener('click',()=>
    {
        
        teacherEls.forEach((El)=>
        {
            El.style.display = "block";
            El.required = true;
        });
        studentEls.forEach((El)=>
        {
            El.style.display = "none";
            El.required = false;
        });
    });
}


//<?php if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) echo ''; ?>