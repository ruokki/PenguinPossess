<?php $possessors = $item['user_id_possess'] === NULL ? array() : explode(',', $item['user_id_possess']); ?>
<a href="<?php echo site_url('user/manageItem/edit/' . $item['item_id']); ?>" 
    class="edit <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
    title="Modifier l'item">
    <span class="icon-pencil"></span>
</a>
<?php $letBorrow = strpos($item['user_let_borrow'], $this->session->user['id'] . '|1') !== FALSE; ?>
<span class="<?php echo $letBorrow === TRUE ? 'icon-unlocked' : 'icon-lock' ?> letBorrow <?php echo in_array($this->session->user['id'], $possessors) ? '' : 'hidden'; ?>"
       data-id="<?php echo $item['item_id']; ?>"
       title="<?php echo $letBorrow === TRUE ? 'Prêt possible' : 'Prêt interdit' ?>"></span>
<span class="<?php echo in_array($this->session->user['id'], $possessors) ? 'icon-checkbox-checked' : 'icon-checkbox-unchecked' ?> possess"
        data-id="<?php echo $item['item_id']; ?>"
        title="<?php echo in_array($this->session->user['id'], $possessors) ? 'Supprimer de ma collection' : 'Ajouter à ma collection' ?>"></span>