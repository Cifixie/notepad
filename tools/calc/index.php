<style type="text/css">
#calc input { width:100%; }
#calc input.display { width:150px; }
</style>
<script type="text/javascript">
function calc_add(value) {
	document.getElementById('calc_display').value = document.getElementById('calc_display').value + value;
}
function calc_sum(value) {
	document.getElementById('calc_display').value = eval(document.getElementById('calc_display').value);
}

</script>
<center>
	<table style="text-align:center;">
		<tr>
			<th colspan="4"><input id="calc_display" type="text" class="display" readonly onclick="this.select()" /></th>
		</tr><tr>
			<td><input type="button" value="F" onclick="alert('kesken')" /></td>
			<td><input type="button" value="/" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="*" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="C" onclick="document.getElementById('calc_display').value = ''" /></td>
		</tr><tr>
			<td><input type="button" value="7" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="8" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="9" onclick="calc_add(this.value)" /></td>
			
			<td><input type="button" value="-" onclick="calc_add(this.value)" /></td>
		</tr><tr>
			<td><input type="button" value="4" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="5" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="6" onclick="calc_add(this.value)" /></td>
			
			<td><input type="button" value="+" onclick="calc_add(this.value)" /></td>
		</tr><tr>
			<td><input type="button" value="1" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="2" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="3" onclick="calc_add(this.value)" /></td>
			
			<td><input type="button" value="=" onclick="calc_sum()" /></td>
		</tr><tr>
			<td><input type="button" value="0" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="(" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value=")" onclick="calc_add(this.value)" /></td>
			<td><input type="button" value="." onclick="calc_add(this.value)" /></td>
		</tr>
	</table>
</center>