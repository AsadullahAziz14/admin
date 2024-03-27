/* [ ---- Beoro Admin - invoices ---- ] */
$(document).ready(function() {
	
   //* subtotal sum
	$('#inv_form').on('keyup','.days, .attendance, .basic, .allowance, .medical_allowance, .arrear, .pkg, .advance, .eobi, .qh, .installment, .electricity, .income_tax, .other_ded ', function() {
		rowInputs();
	});

	function rowInputs() {
		var subTotal = 0;
		var balanceTotal = 0;
		var netTotal = 0;
		$(".invE_table tr").not('.last_row').each(function () {
			var $days = $('.days', this).val();
			var $attendance = $('.attendance', this).val();
			var $basic = $('.basic', this).val();
			var $allowance = $('.allowance', this).val();
			var $medical_allowance = $('.medical_allowance', this).val();
			var $arrear = $('.arrear', this).val();
			var $pkg = $('.pkg', this).val();
			var $advance = $('.advance', this).val();
			var $eobi = $('.eobi', this).val();
			var $qh = $('.qh', this).val();
			var $installment = $('.installment', this).val();
			var $electricity = $('.electricity', this).val();
			var $income_tax = $('.income_tax', this).val();
			var $other_ded = $('.other_ded', this).val();

			var $perDay = (($basic * 1) / ($days * 1));
			var $basicMonth = (($perDay * 1) * ($attendance * 1));
			var $total = (($basicMonth * 1) + ($allowance * 1) + ($medical_allowance * 1)  + ($arrear * 1) + ($pkg * 1));
			var $balance = (($qh * 1) - ($installment * 1));
			var $deduction = (($advance * 1) + ($eobi * 1) + ($installment * 1) + ($electricity * 1) + ($income_tax * 1) + ($other_ded * 1));
			var $net = (($total * 1) - ($deduction * 1));
					  
			var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
			var parsedBalanceTotal = parseFloat( ('0' + $balance).replace(/[^0-9-\.]/g, ''), 10 );
			var parsedNetTotal = parseFloat( ('0' + $net).replace(/[^0-9-\.]/g, ''), 10 );
			
			$('.gross',this).val(parsedSubTotal.toFixed(0));
			$('.balance',this).val(parsedBalanceTotal.toFixed(0));
			$('.net',this).val(parsedNetTotal.toFixed(0));
			
			subTotal += parsedSubTotal;
			balanceTotal += parsedBalanceTotal;
			netTotal += parsedNetTotal;
			
		});	
		
	}
   
});

//!--Get Employee Salary-->
function get_employee_salary(id_emply) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_employee_salary.php",  
		data: "id_emply="+id_emply,  
		success: function(msg){  
			$("#getemployeesalary").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//!--Get get_paymodeadvancesalary-->
function get_paymodeadvancesalary(paymode) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_paymodeadvancesalary.php",  
		data: "paymode="+paymode,  
		success: function(msg){  
			$("#getpaymodeadvancesalary").html(msg); 
			$("#loading").html(''); 
		}
	});  
}


//--Get Employee Salary-->
function get_taxcalculator(m_salary) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_taxcalculator.php",  
		data: "m_salary="+m_salary,  
		success: function(msg){  
			$("#gettaxcalculator").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--Get Employee Salary-->
function get_employee_cnic(emply_cnic) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_employee_cnic.php",  
		data: "emply_cnic="+emply_cnic,  
		success: function(msg){  
			$("#getemployeecnic").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

//--POST BANK ID-->
function get_bank_account(id_bank) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_bank_account.php",  
		data: "id_bank="+id_bank,  
		success: function(msg){  
			$("#getbankaccount").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--GET BANK ACCOUNT TITLE-->
function get_bank_account_title(emply_accountno, id_bank) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_bank_account_title.php",  
		data: "emply_accountno="+emply_accountno+"&id_bank="+id_bank,  
		success: function(msg){  
			$("#getbankaccounttitle").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--GET Report Type to Show Month-->
function get_report_type(type) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_report_type.php",  
		data: "type="+type,  
		success: function(msg){  
			$("#getreporttype").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--GET Employee Attendance-->
function get_department_employees_attendance(id_dept) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_department_employees_attendance.php",  
		data: "id_dept="+id_dept,  
		success: function(msg){  
			console.log(msg);
			$("#getdepartmentemployeesattendance").html(msg); 
			$("#loading").html(''); 
		}
	});  
}

<!--GET Employee Loan Details-->
function get_employee_loan_detail(id_emply) {  
	$("#loading").html('<img src="images/ajax-loader-horizintal.gif"> loading...');  
	$.ajax({  
		type: "POST",  
		url: "include/ajax/salary/get_employee_loan_detail.php",  
		data: "id_emply="+id_emply,  
		success: function(msg){  
			$("#getemployeeloandetail").html(msg); 
			$("#loading").html(''); 
		}
	});  
}