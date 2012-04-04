<p class="code" >

	<select>
		<?php foreach($categories as $categorie): ?>
		<option value="<?php echo $categorie['db']->idcategorie; ?>" >
			<?php for($i=0; $i<$categorie['depth']; $i++) echo '&#160;&#160;'; ?>
			<?php echo $categorie['db']->libellecategorie; ?>
		</option>
		<?php endforeach; ?>
	</select>

</p>