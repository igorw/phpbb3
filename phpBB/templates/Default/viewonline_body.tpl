<tr>
	<td><table border="0" align="center" width="100%" bgcolor="#000000" cellpadding="0" cellspacing="1">
		<tr>
			<td><table border="0" width="100%" cellpadding="3" cellspacing="1">
				<tr class="tableheader">
					<td colspan="4" align="center"><b>There are {ACTIVE_USERS} logged in users and {GUEST_USERS} guest users browsing this board.</b><br />This data is based on users active over the past five minutes.</td>
				</tr>
				<tr class="catheader">
					<td width="35%" align="center">&nbsp;{L_USERNAME}&nbsp;</td>
					<td width="25%" align="center">&nbsp;{L_LAST_UPDATE}&nbsp;</td>
					<td width="40%" align="center">&nbsp;{L_LOCATION}&nbsp;</td>
				</tr>
				<!-- BEGIN userrow -->
				<tr bgcolor="{userrow.ROW_COLOR}" class="tablebody">
					<td width="35%">&nbsp;<a href="{userrow.U_USER_PROFILE}">{userrow.USERNAME}</a>&nbsp;</td>
					<td width="25%" align="center">&nbsp;{userrow.LASTUPDATE}&nbsp;</td>
					<td width="40%">&nbsp;<a href="{userrow.U_FORUM_LOCATION}">&nbsp;{userrow.LOCATION}</a>&nbsp;</td>
				</tr>
				<!-- END userrow -->
			</table></td>
		</tr>
	</table></td>
</tr>