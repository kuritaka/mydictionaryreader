<div class="container">


<script>
function clearText() {
	var textForm = document.getElementById("search");
  textForm.value = '';
}
</script>

<!--参考 http://bootstrap3.cyberlab.info/css/forms-inline.html -->
    <?php 
        echo form_open("/top", 'class="form-inline"');?>
            <div class="form-group">
                <!-- <label class="sr-only" for="pulldown">Dictionary</label> -->
                <select class="form-control" name="pulldown" id="pulldown">
                    <option value="eijiro" <?php echo $select_eijiro; ?>>EIJIRO</option>
                    <option value="waeijiro" <?php echo $select_waeijiro; ?>>WAEIJIRO</option>
                    <option value="reijiro"<?php echo $select_reijiro; ?>>REIJIRO</option>
                    <option value="ryakujiro"<?php echo $select_ryakujiro; ?>>RYAKUJIRO</option>
                </select>
                <!-- <label class="sr-only" for="search">search</label>  -->
                <input type="text" class="form-control" id="search" name="search" placeholder="Search for ..."  value="<?php echo set_value('search', $search); ?>" >
                <button type="submit" class="btn btn-primary"> Search</button>
                <button type="button" class="btn btn-danger" id="inputClearBtn" onclick="clearText()">Clear</button>
            </div>
            <br>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="check01" value="1"  id="check01" <?php echo $check01checked; ?> >
                    <input type="hidden" name="form" value="on">
                     <b>Partial Match</b> &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
                </label>
            </div>
            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" name="radio" value="entry" <?php echo $radio_entry; ?>> <b>Entry</b>
                </label>
                <label class="checkbox-inline">
                    <input type="radio" name="radio" value="desc"  <?php echo $radio_desc; ?> > <b>Description</b>
                </label>
            </div>
      <?php echo form_close(); ?>


    <!-- ================================================================================== -->
    <br />

    <!-- <?php  $count = ($total_rows == 0) ? "$total_rows entries" : "Showing $start to $end of $total_rows entries"; ?> -->
    <?php  echo "Showing $start to $end of $total_rows entries"; ?>

    <!--
    <br \>
    <?php  echo $sql; ?>
    -->

    <br \>
    <br \>

    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
              <tr>
                  <th>Entry</th>
                  <th>Description</th>
              </tr>
      </thead>
      <tbody>
             <?php foreach($dictionary as $dictionary): ?>
             <tr>
                 <td width=""><?php myhtmlview($dictionary['entry'], $search); ?></td>
                 <td><?php myhtmlview($dictionary['desc'], $search); ?></td>
            </tr>
           <?php endforeach; ?>
        </tbody>

        <tfoot>
           <tr>
               <th>Entry</th>
               <th>Description</th>
           </tr>
         </tfoot>

     </table>

     <br \>
     <div class="row">
         <div class="col-md-3">
            <!-- <?php  $count = ($total_rows == 0) ? "$total_rows entries" : "Showing $start to $end of $total_rows entries"; ?> -->
            <?php  echo "Showing $start to $end of $total_rows entries"; ?>
         </div>
         <div class="col-md-9">
             <?php echo $pagination; ?>
         </div>
     </div>

    </div>

