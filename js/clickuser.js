var arr={};
for(var i=1;i<=5;i++){
	var till=11;
	if(i==3)
		till=9;
	for(var j=0;j<=till;j++)
	{
		idd=i*100 + j;
		arr[idd]=0;
	}
}
function cliked(idno){
	if(arr[idno]==0)
	{
		arr[idno]=1;
		document.getElementById(idno).style.backgroundColor="#fff";
		var inpid=6000+idno;
		document.getElementById(inpid).value=1;
	}
	else//if 1
	{
		arr[idno]=0;
		document.getElementById(idno).style.backgroundColor="#cf3";
		var inpid=6000+idno;
		document.getElementById(inpid).value=0;
	}
}