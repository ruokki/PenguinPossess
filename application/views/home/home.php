<div id="me">
    <div id="myCollec">
        <h1>Ma collection</h1>
        <div id="canvasWrapper">
            <canvas id="myChart"></canvas>
        </div>
        <div id="textStat">
            <?php $i = 0; foreach($dataJS['all'] as $one) : ?>
            <?php if($i % 2 === 0) : ?>
            <div class="row">
            <?php endif; ?>
            <div class="column">
                <p><?php echo $one['name']; ?> <span><?php echo $one['total'] ?></span></p>
                <ul>
                    <?php foreach($one['sub'] as $sub) : ?>
                    <li><?php echo $sub['name']; ?> <span><?php echo $sub['nb'] ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php if($i % 2 === 1) : ?>
            </div>
            <?php endif; ?>
            <?php $i++; endforeach; ?>
        </div>
    </div>
    <div id="lendBorrow">
        <div id="lend">
            <h1>Demandes en attente</h1>
            <div>
                <?php foreach($lends as $item) : ?>
                <div class="lend">
                    <div><?php echo $item['borrower_name']; ?></div>
                    <div><?php echo $item['item_name']; ?></div>
                    <div><?php echo $item['borrow_length']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="borrow">
            <h1>Emprunt</h1>
            <div>
                <?php foreach($borrows as $item) : ?>
                <div class="lend">
                    <div><?php echo $item['lender_name']; ?></div>
                    <div><?php echo $item['item_name']; ?></div>
                    <div><?php echo $item['borrow_date_end']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div id="lastItems">
    <h1>Derniers ajouts dans la Bibliothèque</h1>
    <div class="listItem">
    <?php if(count($items) === 0) : ?>
        <p>Aucun item</p>
    <?php else : ?>
        <?php foreach($items as $item) : ?>
        <?php $this->load->view('template/oneItem', array('item' => $item)); ?>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
</div>

<script>
    var labels = <?php echo json_encode($dataJS['labels']); ?>;
    var data = <?php echo json_encode($dataJS['data']); ?>;
</script>