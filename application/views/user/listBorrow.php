<table>
    <caption class="text-left">
        <span class="icon-info"></span>
        <span class="title">Fonctionnement des emprunts</span>
    </caption>
    <thead>
        <tr>
            <th>Nom de l'item</th>
            <th>Demandé/Emprunté à</th>
            <th>Date de la demande</th>
            <th>État de la demande</th>
            <th>Date de début</th>
            <th>Date de fin</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($items as $item) : ?>
        <tr data-id="<?php echo $item['borrow_id']; ?>">
            <td><?php echo $item['item_name']; ?></td>
            <td><?php echo $item['lenders_name']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_create'])); ?></td>
            <td>
                <?php echo $state[$item['borrow_state']]; ?>
                <?php if(date('d/m/Y', strtotime($item['borrow_date_renew_asked'])) === '01/01/2000') : ?>
                (rallonge refusée)
                <?php elseif(date('d/m/Y', strtotime($item['borrow_date_renew_asked'])) === date('d/m/Y', strtotime($item['borrow_date_end']))) : ?>
                (rallonge acceptée)
                <?php endif; ?>
            </td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_begin'])); ?></td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_end'])); ?></td>
            <td class="text-center">
                <?php if($item['borrow_state'] === 'WA') : ?>
                <span class="delete icon-cross" title="Supprimer ma demande"></span>
                <?php elseif($item['borrow_state'] === 'TB') : ?>
                <span class="delete icon-cross" title="Supprimer ma demande"></span>
                <?php elseif($item['borrow_state'] === 'BO') : ?>
                <span class="askRenew icon-spinner11" data-old="<?php echo date('d/m/Y', strtotime($item['borrow_date_end'])); ?>" title="Demander une rallonge"></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Fonctionnement des prêts -->
<div id="modalRuleBorrow">
    <p>Les emprunts fonctionnent de la façon suivante :</p>
    <ul>
        <li>Vous effectuez une demande de prêt</li>
        <li>Le propriétaire reçoit une demande sur son compte. Il dispose de 2 options :</li>
        <li>
            Soit il accepte et votre demande passe en état "<?php echo $state['TB']; ?>"
        </li>
        <li>
            Soit il refuse votre demande et indique un motif.
        </li>
        <li>
            En cas d'acceptation, à vous de régler avec le propriétaire le moment et l'endroit où il vous transmettra l'item ainsi que la durée du prêt
        </li>
        <li>
            Une fois transmis, le propriétaire passe la demande en état "<?php echo $state['BO']; ?>" et indique la durée convenu.<br />
            Une notification s'affichera une semaine avant la fin du prêt sur le menu "Mes emprunts" indiquant le nombre d'item arrivant à échéance.
        </li>
        <li>
            Il est possible de demander une rallonge (ou un raccourcissement) de la durée du prêt à l'aide de l'icone <span class="icon-spinner11"></span>
        </li>
        <li>
            Une fois l'item rendu, le priopriétaire passe la demande en état "<?php echo $state['GB']; ?> et celle-ci disparait de votre interface.
        </li>
    </ul>
</div>

<!-- Modification de la date de fin -->
<div id="modalRenewBorrow">
    <p>Date de fin actuelle : <span></span></p>
    <label for="newEndDate">Veuillez indiquer la date de fin souhaitée</label>
    <input type="text" id="newEndDate" name="newEndDate" placeholder="jj/mm/aaaa" />
    <input type="hidden" id="idBorrowRenew" name="idBorrowRenew" />
    <input type="hidden" id="cmdRenew" name="cmdRenew" value="askRenew" />
</div>
