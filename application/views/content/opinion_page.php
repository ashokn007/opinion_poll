<style>
    /* vote */
    .box-opinion {
        background: #fff;
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.18);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.18);
        box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.18);
        border-radius: 3px;
        float: right;
        width: 100%;
    }

    .box-opinion-head {
        background: #792c92;
        font-size: 20px;
        color: #ffffff;
        float: right;
        padding: 5px;
        font-family: sans-serif;
        width: 100%;
    }

    .box-opinion-content {
        float: right;
        padding: 10px;
        width: 100%;
    }

    .box-opinion-content label {
        font-family: sans-serif;
        font-size: 15px;
        color: #5e5e5e;
        font-weight: 2px;
    }

    .box-opinion-content .radio input[type=radio] {
        margin-top: 10px;
    }

    /* footer */
</style>
<script type="text/javascript">

    $(document).ready(function () {
        $("#opinion_categories").submit(function () {

            var dvId = $("#dv_id").val();
            var v_column = $('input[name="v_column"]:checked').val();
            var v_data = $('input[name="v_data"]').val();
            var sendData = {"v_column": v_column,"v_data": v_data};

            $.ajax({
                url: "<?= base_url(); ?>opinion/submit_opinion/" + dvId,
                type: "post",
                data: sendData,
                success: function (data) {
                    $("#box-opinion").fadeOut(1000);
                    $("#poll-results").html(data).delay(1000).fadeIn(1000);
                }
            });

            return false;

        })

    })

</script>
<!-- Opinion Start -->
        <?php if($columns !=null){?>
        <?= form_open_multipart('opinion/submit_opinion/'.$vote->dv_id, array('id' => 'opinion_categories'))?>

        <div  class="col-md-6 margin-top-30">
            <div id="box-opinion" class="box-opinion">

                <div class="box-opinion-head"><?= $vote->dv_title?></div>
                <div class="box-opinion-content">
                    <input type="hidden" id="dv_id" value="<?= $vote->dv_id; ?>"/>
            <?php foreach($columns as $key=>$value):  ?>
            <div class="radio">
                <label class="voting_blog">
                <input name="v_column" type="radio" value="<?= $key ?>,<?= $value ?>" checked="checked" >
                <?= $value ?>
                </label>
            </div>
              <?php  endforeach;  ?>
              <button type="submit" name="opinions"  class="btn-block">Submit !</button>
                </div>

            </div>
            <div id="poll-results" style="display:none;"></div>
        </div>
        </form>
    <?php }else{?> <p class="notice error">sorry,there no opinion Poll</p>  <?php } ?>
<!-- opinion End -->

