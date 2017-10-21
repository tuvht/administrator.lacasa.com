<footer>

    <div class="footinfo">
        <div class="container">
            <div class="row text-center">
                <div class="siteinfo">
                    <p>Copyright © AsianTechHub.com. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>

</footer>
</div>

<?php
$sort_dir   = isset($_GET['dir'])?$_GET['dir']:0;
$sort_order = isset($_GET['order'])?$_GET['order']:0;
?>
<?php if ($sort_order != '0' && $sort_dir != '0'):?>
<script type="text/javascript">
    $(document).ready(function() {
<?php if (strtolower($sort_dir) == 'asc'):?>
        jQuery('a[href*="?order=<?php echo $sort_order;?>"]').addClass('sort').append('<i class="fa fa-sort-asc" aria-hidden="true"></i>');
<?php endif;?>
      <?php if (strtolower($sort_dir) == 'desc'):?>
        jQuery('a[href*="?order=<?php echo $sort_order;?>"]').addClass('sort').append('<i class="fa fa-sort-desc" aria-hidden="true"></i>');
<?php endif;?>
});
  </script>
<?php  else :?>
<script type="text/javascript">
    $(document).ready(function() {
      jQuery('a[href*="?order"]').each(function(index, val) {
        if ( index == 0 ) {
          jQuery(this).addClass('sort').append('<i class="fa fa-sort-desc" aria-hidden="true"></i>');
        }
      });
    });
  </script>
<?php endif;?>
</html>
