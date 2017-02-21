<table>
    <thead>
        <tr>
            <th>Nom de l'item</th>
            <th>Date de la demande</th>
            <th>État de la demande</th>
            <th>Demandeur</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($items as $item) : ?>
        <tr>
            <td><?php echo $item['item_name']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_create'])); ?></td>
            <td><?php echo $state[$item['borrow_state']]; ?></td>
            <td><?php echo $item['borrower_name']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>