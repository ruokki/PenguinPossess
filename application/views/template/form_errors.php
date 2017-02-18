<ul id="errors">
    <span id="closeError" class="icon-cross"></span>
    <?php foreach($errors as $txt) : ?>
    <li><?php echo $txt; ?></li>
    <?php endforeach; ?>
</ul>