function chanceVisible(student)
{
    if(student)
    {
        document.getElementById("teacherSelected").style.display = "none";
        document.getElementById("schoolName").required = false;
        document.getElementById("schoolLocation").required = false;
    }
    else
    {
        document.getElementById("teacherSelected").style.display = "block";
        document.getElementById("schoolName").required = true;
        document.getElementById("schoolLocation").required = true;
    }
}