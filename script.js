function chanceVisible(student)
{
    if(student)
    {
        document.getElementById("studentSelected").style.display = "block";
        document.getElementById("teacherSelected").style.display = "none";
    }
    else
    {
        document.getElementById("studentSelected").style.display = "none";
        document.getElementById("teacherSelected").style.display = "block";
    }
}