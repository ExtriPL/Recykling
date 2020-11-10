const formEls = document.querySelectorAll("#regForm input, #regForm select");


const teacherEls = document.querySelectorAll(".addTeacher");
const studentEls = document.querySelectorAll(".addStudent");


const roleStudentRadioEl = document.getElementById("role1");
const roleTeacherRadioEl = document.getElementById("role2");

teacherEls.forEach((El)=>
{
    El.style.display = "none";
    El.required = false;
    El.disabled = true;
});
studentEls.forEach((El)=>
{
    El.style.display = "block";
    El.required = true;
    El.disabled = false;
});


formEls.forEach((inputEl)=>{
    inputEl.addEventListener('input',()=>{
        document.querySelector(".backMsg").innerHTML="";
    });
});

if(roleTeacherRadioEl)
{
    roleStudentRadioEl.addEventListener('click',()=>
    {
        teacherEls.forEach((El)=>
        {
            El.style.display = "none";
            El.required = false;
            El.disabled = true;
        });
        studentEls.forEach((El)=>
        {
            El.style.display = "block";
            El.required = true;
            El.disabled = false;
        });
    });


    roleTeacherRadioEl.addEventListener('click',()=>
    {
        
        teacherEls.forEach((El)=>
        {
            El.style.display = "block";
            El.required = true;
            El.disabled = false;
        });
        studentEls.forEach((El)=>
        {
            El.style.display = "none";
            El.required = false;
            El.disabled = true;
        });
    });
}


