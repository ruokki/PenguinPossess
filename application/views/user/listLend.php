<table>
    <?php if(isset($oldLent) && $oldLent === TRUE) : ?>
    <caption class="text-center">
        <span class="title">Historique des prêts</span>
    </caption>
    <?php else : ?>
    <caption class="text-left">
        <span class="icon-info"></span>
        <span class="title">Fonctionnement des prêts</span>
    </caption>
    <?php endif; ?>
    <thead>
        <tr>
            <th>Nom de l'item</th>
            <th>Demandeur</th>
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
            <td class="borrower"><?php echo $item['borrower_name']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_create'])); ?></td>
            <td><?php echo $state[$item['borrow_state']]; ?></td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_begin'])); ?></td>
            <td><?php echo date('d/m/Y', strtotime($item['borrow_date_end'])); ?></td>
            <td class="text-center">
                <?php if($item['borrow_state'] === 'WA') : ?>
                <span class="accept icon-checkmark" title="Accepter la demande"></span>
                <span class="deny icon-cross" title="Refuser la demande"></span>
                <?php elseif($item['borrow_state'] === 'TB') : ?>
                <span class="given icon-truck" title="Item prété"></span>
                <?php elseif($item['borrow_state'] === 'BO') : ?>
                <span class="renew icon-spinner11" data-old="<?php echo date('d/m/Y', strtotime($item['borrow_date_end'])); ?>" title="Modifier la date de fin du prêt"></span>
                <span class="stop icon-stop2" title="Terminer le prêt"></span>
                <?php elseif($item['borrow_state'] === 'AR') : ?>
                <span class="seeRenew icon-eye" data-old="<?php echo date('d/m/Y', strtotime($item['borrow_date_end'])); ?>" data-new="<?php echo date('d/m/Y', strtotime($item['borrow_date_renew_asked'])); ?>" title="Voir la demande de rallonge"></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if(isset($oldLent) && $oldLent === TRUE) : ?>
<?php else : ?>
<!-- Fonctionnement des prêts -->
<div id="modalRuleBorrow">
    <p>Les prêts fonctionnent de la façon suivante :</p>
    <ul>
        <li>Un autre utilisateur effectue une demande concernant un de vos items.</li>
        <li>Cette demande apparait dans votre liste avec le statut "<?php echo $state['WA']; ?>".</li>
        <li>Vous choisissez si oui ou non, vous voulez prêter l'item.</li>
        <li>
            Si vous décidez de le prêter, l'item passe en état "<?php echo $state['TB']; ?>". A vous définir avec 
            l'autre utilisateur où, quand et pour combien de temps vous allez lui transmettre l'item.
        </li>
        <li>
            Une fois transmis, vous devez revenir sur cette interface et indiquer que c'est l'autre utilisateur qui l'a
            en sa possession en cliquant sur l'icone <span class="icon-truck"></span>
        </li>
        <li>
            Indiquer la durée du prêt. Une notification sera affiché pour l'emprunteur une semaine avant
            la date de fin du prêt. Il est possible d'allonger la durée du prêt à l'aide de l'icone <span class="icon-spinner11"></span>
        </li>
        <li>Il est possible de terminer le prêt avant la date limite.</li>
        <li>
            Une fois le prêt terminé et l'item rendu, cliquer sur l'icone <span class="icon-stop2"></span> pour terminer le prêt
            et rendre l'item à nouveau disponible. <br />
            NE TERMINER PAS UN PRÊT TANT QUE VOUS N'AVEZ PAS RÉCUPÉRÉ L'ITEM
        </li>
    </ul>
</div>

<!-- Demande refusée, ajout d'un motif -->
<div id="modalJustifDeny">
    <p>Veuiller indiquer un motif du refus</p>
    <textarea id="textDeny"></textarea>
    <input type="hidden" id="idDemandeDeny" />
</div>

<!-- Item prété, configuration du nombre de jour -->
<div id="modalBorrowBegin">
    <label for="nbJourLend">Combien de jours prêtez-vous l'item ?</label>
    <input type="integer" id="nbJourLend" name="nbJourLend" min="0" value="15" />
    <p>Retour le <span></span></p>
    <input type="hidden" id="idBorrowBegin" name="idBorrowBegin" />
</div>

<!-- Confirmation de fin de prêt -->
<div id="modalConfirmEnd">
    <p>L'item a-t-il été récupéré ?</p>
    <input type="hidden" id="idBorrowEnd" name="idBorrowEnd" />
</div>

<!-- Modification de la date de fin -->
<div id="modalRenewBorrow">
    <p>Date de fin actuelle : <span></span></p>
    <label for="newEndDate">Veuillez indiquer la nouvelle date de fin</label>
    <input type="text" id="newEndDate" name="newEndDate" placeholder="jj/mm/aaaa" />
    <input type="hidden" id="idBorrowRenew" name="idBorrowRenew" />
    <input type="hidden" id="cmdRenew" name="cmdRenew" value="renew" />
</div>

<div id="modalSeeRenew">
    <p>Une rallonge a été demandée pour cet item.</p>
    <p>Date de fin actuelle : <span class="old"></span></p>
    <p>Nouvelle date de fin : <span class="new"></span></p>
    <input type="hidden" id="idBorrowRenewAsked" name="idBorrowRenewAsked" />
</div>
<?php endif; ?>