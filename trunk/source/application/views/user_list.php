<table>

<?php foreach($users as $user): ?>

<tr>
	<td><?php echo $user->user_pseudo; ?></td>
	<td><?php echo $user->user_date; ?></td>
</tr>

<?php endforeach; ?>

</table>