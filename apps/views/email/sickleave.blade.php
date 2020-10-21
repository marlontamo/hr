<style>
   body {font-family: sans-serif, arial; font-size: 14px; }
   p, span {line-height: 18px;}
</style>

<p>Good day!</p>
<p>
	You are receiving this email because {{fullname}} filed for a {{form}} on {{date}} and is now awaiting for your approval.
</p>
	<span>Filed on : {{datetime}}<br></span>
	<san>Inclusive Date : {{inclusive}}<br></span>
	<span>No. of Day : {{days}}<br></span>
	<span>Reason : {{reason}}<br></span>
</p>
<p>Kindly approve/disapprove this application on/before the payroll cut-off. If approval has been made after, please note that adjustments, if any, will be made the next salary period.</p>
<p>Leave Credits as of:</p>
<table border=0 cellspacing=0 cellpadding=0 style="width:75%;border:1px solid #e0e0e0">
	<th>
		<tr>
			<td style="width:25%">&nbsp;</td>
			<td style="width:15%">Previous<br>Year (if any)</td>
			<td style="width:15%">Earned<br>this Year</td>
			<td style="width:15%">Used</td>
			<td style="width:15%">Balance</td>
			<td style="width:15%">Pending</td>
		</tr>
	</th>
	{{table_body}}
</table>

<p>To approve/disapprove, just click <a href="{{link}}">here</a>.</p>
<p>{{system_title}}</p>
<p>Note: This is a system generated message.</p>