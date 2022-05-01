<?php if ($disponible['8_10'] != 1 && $disponible['10_12'] != 1 && $disponible['12_14'] != 1 && $disponible['14_16'] != 1 && $disponible['16_18'] != 1 && $disponible['18_20'] != 1 && $disponible['20_22'] != 1) { ?>
	<p style="color:red;">Ce mentor n'est pas disponible sur ce jour.</p>
<?php } else { ?>
    <?php if (empty($holidays)) { ?>
		<span class="horaire_td  <?php if ($disponible['8_10'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="8h-10h" name="crenaux[]" class="<?php if ($disponible['8_10'] == 1) echo 'check_disp'; ?>" <?php if ($disponible['8_10'] != 1) echo 'disabled'; ?>>8h-10h</span>
		<span class="horaire_td  <?php if ($disponible['10_12'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="10h-12h" name="crenaux[]" class="<?php if ($disponible['10_12'] == 1) echo 'check_disp'; ?>" <?php if ($disponible['10_12'] != 1) echo 'disabled'; ?>>10h-12h</span>
		<span class="horaire_td  <?php if ($disponible['12_14'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="12h-14h" name="crenaux[]" class="check_disp" <?php if ($disponible['12_14'] != 1) echo 'disabled'; ?>>12h-14h</span>
		<span class="horaire_td  <?php if ($disponible['14_16'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="14h-16h" name="crenaux[]" class="check_disp" <?php if ($disponible['14_16'] != 1) echo 'disabled'; ?>>14h-16h</span>
		<span class="horaire_td  <?php if ($disponible['16_18'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="16h-18h" name="crenaux[]" class="check_disp" <?php if ($disponible['16_18'] != 1) echo 'disabled'; ?>>16h-18h</span>
		<span class="horaire_td  <?php if ($disponible['18_20'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="18h-20h" name="crenaux[]" class="check_disp" <?php if ($disponible['18_20'] != 1) echo 'disabled'; ?>>18h-20h</span>
		<span class="horaire_td  <?php if ($disponible['20_22'] != 1) echo 'disabled'; ?>"><input type="checkbox" value="20h-22h" name="crenaux[]" class="check_disp" <?php if ($disponible['20_22'] != 1) echo 'disabled'; ?>>20h-22h</span>
    <?php } else { ?>
		<p style="color:red;">Ce mentor n'est pas disponible sur ce jour.</p>

    <?php }
} ?>