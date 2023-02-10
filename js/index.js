$("#btnExport").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#reportexcel').html()));
    e.preventDefault();
});


$(document).ready(function(){
	$('#tabledata tr').click(function(){
	var href=$(this).find("a").attr("href");
	if (href){
		window.location.href = href;
		//MyPopUpWin(href, 600, 600);
		
	}
	});
});

$(document).ready(function(){
	$('#tabledata2 tr').click(function(){
	var href=$(this).find("a").attr("href");
	if (href){
		openCenteredWindow(href);
		//window.open (href, 'popup', 600, 600);
		//MyPopUpWin(href, 600, 600);
	}
	});
});

var myWindow;

function chgm(){
	//alert('Hello');
		var sem =  document.getElementById('semes').value;
		if (sem=='3'){
				document.getElementById("m4").disabled = true;
				document.getElementById("m5").disabled = true;
				//document.getElementById("m6").disabled = true;
		}else{
			    document.getElementById("m4").disabled = false;
				document.getElementById("m5").disabled = false;
				//document.getElementById("m6").disabled = false;
		}

}

function openCenteredWindow(url) {
    var width = 1000;
    var height = 580;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "width=" + width + ",height=" + height + ",location,directories,status,resizable,toolbar,menubar,left=" + left + ",top=" + top + "screenX=" 
	+ left + ",screenY=" + top;
    myWindow = window.open(url, "subWind", windowFeatures);
}


$(document).ready(function() {
    $('#tabledata').DataTable( {
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }, {
            targets: [ 4 ],
            orderData: [ 4, 0 ]
        } ]
    } );
} );


$(document).ready(function() {
    $('#tabledata2').DataTable( {
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }, {
            targets: [ 4 ],
            orderData: [ 4, 0 ]
        } ]
    } );
} );



$("#selectedhostel").on('change', function() {
	var selectedhos =  document.getElementById('selectedhostel').value;//eg beliawanis
	//alert(selectedhos);
	
	var cur_d=(new Date).getDate();
	var cur_m=(new Date).getMonth() + 1;
	var cur_y=(new Date).getFullYear();
	var d=new Date (cur_y, cur_m, 0).getDate();//get last day of the month
	var pay_type="DAY";
	var cor=0;
	
	$.getJSON('/fees-list.php', function(data){
		$('#feesdet').empty();
		//$('#feesdet').html(d);
		
		$.each(data, function(index, data) {
		if (data.year==cur_y && data.description==selectedhos && data.month==cur_m){
			var tot=Number(d-cur_d)*10;//can be set by hos_manager or admin if they want to increase the day rate
			//data.fees_per_month
			if (tot>data.fees_per_month){
				tot=data.fees_per_month;
				pay_type="FIX";
				cor++;
			}else{
				cor++;
			}
			
			document.getElementById('feesdet').innerHTML+="<b>TOTAL: </b>RM "+tot+ "<br><b>FEE TYPE:</b> "+pay_type;
			document.getElementById('totfees').value=tot;
			}
    });
	
	if (cor==0){
		document.getElementById('feesdet').innerHTML+="PLEASE INSERT THE HOSTEL'S NEW FEE RATE FOR THIS MONTH";
		document.getElementById('totfees').value=0;
	}
	
    }); 
	
	$.getJSON('/unit-list.php', function(data){
		$('#selectunit').empty();
		$('#selectunit').append('<option value="" selected="selected">Select</option>');
		$.each(data, function(index, data) {
		if(data)	
		$avail=data.umo-data.tot_occ;
		if (data.hosname==selectedhos && $avail>0){
		//$('#selectunit').append('<option value="'+data.unitno+'">'+data.unitno+': '+$avail+ ' availability' + '</option>'); }
			
		//DO NOT ALLOW CHECK IN TO EXPIRED ROOM OR ROOM ABOUT TO EXPIRED IN ONE MONTH
			if (Number(data.y)>Number(cur_y)){
			$('#selectunit').append('<option value="'+data.unitno+'">'+data.unitno+': '+$avail+ ' availability' + '</option>'); 
			}
			else if(Number(data.y)==Number(cur_y)){
				if(Number(data.m)>Number(cur_m)){
					$('#selectunit').append('<option value="'+data.unitno+'">'+data.unitno+': '+$avail+ ' availability' + '</option>'); 
				}
			}
		}
    });
    $("#selectunit").select("refresh");
    }); 
});

$("#selectunit").on('change', function() {
	var selectedhos =  document.getElementById('selectedhostel').value;//eg beliawanis
	var selectedun =  document.getElementById('selectunit').value;//eg A-1-3
	var cor=0;
	
	$.getJSON('/occ-list.php', function(data){
		$('#hosdet').empty();
		document.getElementById('hosdet').innerHTML+="<ul style=\"display:table;table-layout:fixed;width:100%;color:green\"><li style=\"display: table-cell\">"+
		"MATRIC</li><li style=\"display: table-cell\">NAME</li><li style=\"display: table-cell\">PROGRAM</li>"+
		"<li style=\"display: table-cell;\">YEAR</li></li></ul><hr>"; 
		$.each(data, function(index, data) {
		if (data.unit_no==selectedun && data.hos_name==selectedhos && data.status=='CI'){
			document.getElementById('hosdet').innerHTML+="<ul style=\"display:table;table-layout:fixed;width:100%\"><li style=\"display: table-cell\">"
			+data.matric+"</li><li style=\"display: table-cell\">"+data.first_name+" "+data.last_name+"</li><li style=\"display: table-cell\">"+data.program+"</li>"+
			"<li style=\"display: table-cell;\">"+data.year+"</li></li></ul>"; 
			//cor++;
			}
    });
	
    });
		
});

function feetypef() {
	//alert('yos');
	var feetype =  document.getElementById('feetype').value;//eg beliawanis
	//alert(selectedhos);
		
		
		 if (feetype=='hostel'){
			$('#desc').empty();
			$('#desc').append('<option value="" selected="selected">Select</option>');
			$.getJSON('/hostel-list.php', function(data){
			$.each(data, function(index, data) {
				
				$('#desc').append('<option value="'+data.hos_name+'">'+data.hos_name+ '</option>'); 
			
		});
		$("#feetype").select("refresh");
		});
		}else{
			$('#desc').empty();
			$('#desc').append('<option value="" selected="selected">Select</option>');
		}
}

function descr(){
	  $('#mnthapp').empty();
	  $("#mnthapp").val($("#mnthapp").data("default-value"));

	var desc = document.getElementById('desc').value;
	
	$('#mnthapp').empty();
	$('#mnthapp').append('<option value="" selected="selected">Select</option>');
	$.getJSON('/sem-list.php', function(data){
			$.each(data, function(index, data) {
			
				if(data.hos_name==desc){
					//it means that the hostel has not yet set current month rate on fees setting
					if (data.description!=desc){
						// alert('he');
					    var dateapp=new Date("1-"+data.month+"-"+data.year);
						var dateapp2=data.month+"-"+data.year;
						var m=((new Date(dateapp)).getMonth() + 1).toString();
						var y=((new Date(dateapp)).getFullYear()).toString();
						var curm=((new Date).getMonth() + 1).toString();
						var cury=(new Date).getFullYear().toString();
						
						if (m==curm && y==cury){
							$('#mnthapp').append('<option value="'+dateapp2+'">'+dateapp2+'</option>'); }
						//return false;
						}
				}	
		});
		$("#semmm").select("refresh");
		});
		
}

function setrate(){
	var desc =  document.getElementById('desc').value;
	var rset =  document.getElementById('rset').value;
	var old=0;
	//alert(desc);
	
	if (rset=='old'){
		$.getJSON('/sem-list.php', function(data){
			$.each(data, function(index, data) {
					
				if(data.hos_name==desc){
					if(data.amount!=null){
					old=data.amount;
					}
					
					//it means that the hoste has not yet set current month rate on fees setting
					if (data.description!=desc){
					
					    var dateapp=new Date("1-"+data.month+"-"+data.year);
						var dateapp2=data.month+"-"+data.year;
						var m=((new Date(dateapp)).getMonth()).toString();
						var y=((new Date(dateapp)).getFullYear()).toString();
						var curm=((new Date).getMonth() + 1).toString();
						var cury=(new Date).getFullYear().toString();		
						
						if (m==curm && y==cury){
							document.getElementById('rental').value=old;
							//alert(old);
							return false;
							}
						}
					
				}
		});
		
		});
		
	}
}

function dateapp(){

	var mnthapp=document.getElementById('mnthapp').value.split('-');
	$('#exp').empty();
	var myDate = new Date(mnthapp[0] + " 1, 2000");
    var monthDigit = myDate.getMonth();
	var mont=isNaN(monthDigit) ? 0 : (monthDigit + 1 + 1);
	
	document.getElementById('exp').value='01-'+mont+'-'+mnthapp[1];
}




function chgpaystat() {
	//alert("Hello!");
	var stat =  document.getElementById('selectstat').value;
	//alert(manager);
	if(stat=="PAID"){
	document.getElementById("payid").disabled = false;
	document.getElementById("datepay").disabled = false;
}else{
	document.getElementById("payid").disabled = true;
	document.getElementById("datepay").disabled = true;
}
}

function payeecol() {
	//alert("Hello!");
	var stat =  document.getElementById('payee_name').value;
	//alert(manager);
	if(stat=="Other"){
	document.getElementById("new_payee_name").disabled = false;
	//document.getElementById("datepay").disabled = false;
}else{
	document.getElementById("new_payee_name").disabled = true;
	//document.getElementById("datepay").disabled = true;
}
}


function statcol() {
	//alert("Hello!");
	var ps =  document.getElementById('pay_status').value;
	
	
	if(ps=="PAID"){
	document.getElementById("pay_voucher").disabled = false;
	document.getElementById("date_pay").disabled = false;
}else{
	document.getElementById("pay_voucher").disabled = true;
	document.getElementById("date_pay").disabled = true;
}
}

function chgpayeetype() {
	//alert("Hello!");
	var pt =  document.getElementById('pay_type').value;
	
	if(pt!="BUS"){
	document.getElementById("hos_n").disabled = false;
	
}else{
	document.getElementById("hos_n").disabled = true;

}
}

function addMonthParam(){
	
	var currentMonth=document.getElementById('filterbymonth').value;
	
	//$('#filterbymonth').val(currentMonth);

	var paramName = "month";
	var paramValue = currentMonth;
	setGetParameter(paramName, paramValue);
	
    
}


function addMonthParam(){
	
	var currentMonth=document.getElementById('filterbymonth').value;
	
	//$('#filterbymonth').val(currentMonth);

	var paramName = "month";
	var paramValue = currentMonth;
	setGetParameter(paramName, paramValue);
	
    
}

function addYearParam(){
	
	var currentYear=document.getElementById('filterbyyear').value;
	
	var currentMonth=document.getElementById('filterbymonth').value;
	
	
	var paramName = "year";
	var paramValue = currentYear;
	setGetParameter(paramName, paramValue);
	
	
}

function setGetParameter(paramName, paramValue)
{
    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0)
    {
        var prefix = url.substring(0, url.indexOf(paramName));
        var suffix = url.substring(url.indexOf(paramName));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
    if (url.indexOf("?") < 0)
        url += "?" + paramName + "=" + paramValue;
    else
        url += "&" + paramName + "=" + paramValue;
    }
    window.location.href = url + hash;
	
}

function logout(){
	//var r = confirm("You are about to log out!");
	if (confirm("You are about to log out!")){
		window.location="index.php";
		//alert('Okay it is working');
	}
}

function goBack() {
			window.history.back();
		}
		
