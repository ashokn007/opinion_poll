<?php if (isset($result) && $result != NULL) { ?>    <!-- poll Result Start -->    <div class="box-opinion">        <div class="box-opinion-head">Result of : <?php echo $result->dv_title ?></div>        <div class="box-opinion-content">                <div class="span6">                   <h5>Vote Counter: <?php  ?></h5>                    <?php foreach($rows as $row): ?>                    <label class="label"><?= $row['prec']; ?>% (<?= $row['v_data']; ?>)</label>                    <div class="progress">                        <progress class="progress progress-striped progress-success" role="progressbar"                             aria-valuenow="40"  max="100" value="<?= $row['prec']; ?>">                        </progress>                    </div>                    <?php endforeach; ?>                </div>            </div>        </div>        <!-- poll Result End --><?php }else{ ?>    <div class="alert alert-warning">  <strong></strong></div><?php } ?>